<?php

namespace Signifly\Travy\Http\Controllers;

use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Signifly\Travy\Http\Actions\IndexAction;
use Signifly\Travy\Http\Requests\TravyRequest;
use Illuminate\Database\Eloquent\Relations\Relation;

class RelationController extends Controller
{
    public function index(TravyRequest $request)
    {
        $relationName = $request->relationName();
        $model = $request->resource()->findOrFail($request->resourceId());

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
        $model = $request->resource()->findOrFail($request->resourceId());

        $this->guardAgainstInvalidRelation($model, $relationName);

        $relationResource = $request->relationResource();

        $relatedModel = $model->$relationName()
            ->with($relationResource->with())
            ->findOrFail($request->relationId());

        return $this->respondForModel($relatedModel);
    }

    /**
     * Guard against invalid relations
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $relationName
     */
    protected function guardAgainstInvalidRelation($model, $relationName)
    {
        abort_unless(
            $this->hasRelation($model, $relationName),
            404,
            'Not Found.'
        );
    }

    /**
     * Checks if a model has a given relation.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $relationName
     * @return bool
     */
    protected function hasRelation(Model $model, string $relationName)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($model->relationLoaded($relationName)) {
            return true;
        }

        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        if (method_exists($model, $relationName)) {
            return is_a($model->$relationName(), Relation::class);
        }

        return false;
    }

    /**
     * Determines if the relation returns a single association
     *
     * @param  \Illuminate\Database\Eloquent\Relations\Relation $relation
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
