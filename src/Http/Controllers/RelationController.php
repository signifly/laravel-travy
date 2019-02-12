<?php

namespace Signifly\Travy\Http\Controllers;

use Signifly\Travy\Http\Actions\IndexAction;
use Signifly\Travy\Http\Requests\TravyRequest;

class RelationController extends Controller
{
    public function index(TravyRequest $request)
    {
        $relationName = $request->relationName();
        $model = $request->resource()->findOrFail($request->id);

        $this->guardAgainstInvalidRelation($model, $relationName);

        $relation = $model->$relationName();
        $relationResource = $request->relationResource();

        // If the relation has a single association to another model
        // then retrieve the first result and return it
        if ($this->returnSingleAssociation($relation)) {
            return $this->respondForModel(
                $relation->with($relationResource->with())->first()
            );
        }

        // Otherwise we'll build a paginated query using the index action
        $action = new IndexAction(
            $request,
            $relationResource,
            $relation->getQuery()
        );

        $paginator = $this->dispatch($action);

        return $this->respondForPaginator(
            $paginator,
            get_class($relation->getRelated())
        );
    }

    public function show(TravyRequest $request)
    {
        $relationName = $request->relationName();
        $model = $request->resource()->findOrFail($request->id);

        $this->guardAgainstInvalidRelation($model, $relationName);

        $relationResource = $request->relationResource();

        $relatedModel = $model->$relationName()
            ->with($relationResource->with())
            ->findOrFail($request->relationId());

        return $this->respondForModel($relatedModel);
    }

    /**
     * Guard against invalid relations.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $relationName
     */
    protected function guardAgainstInvalidRelation($model, $relationName)
    {
        abort_unless(
            $model->hasRelation($relationName),
            404,
            'Not Found.'
        );
    }

    /**
     * Determines if the relation returns a single association.
     *
     * @param \Illuminate\Database\Eloquent\Relations\Relation $relation
     *
     * @return bool
     */
    protected function returnSingleAssociation($relation)
    {
        $classes = collect([
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            \Illuminate\Database\Eloquent\Relations\HasOne::class,
            \Illuminate\Database\Eloquent\Relations\MorphTo::class,
            \Illuminate\Database\Eloquent\Relations\MorphOne::class,
        ]);

        $relation = $classes->first(function ($class) use ($relation) {
            return is_a($relation, $class);
        });

        return $relation ? true : false;
    }
}
