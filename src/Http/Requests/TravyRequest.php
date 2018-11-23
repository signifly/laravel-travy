<?php

namespace Signifly\Travy\Http\Requests;

use Signifly\Travy\Support\RulesetSorter;
use Signifly\Travy\Support\ActionFactory;
use Signifly\Travy\Support\ResourceFactory;
use Illuminate\Foundation\Http\FormRequest;

class TravyRequest extends FormRequest
{
    /** @var \Signifly\Travy\Http\Actions\Action */
    protected $action;

    /** @var \Signifly\Travy\Resource */
    protected $resource;

    /** @var \Signifly\Travy\Resource */
    protected $relationResource;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $actionMethod = $this->route()->getActionMethod();

        if (! in_array($actionMethod, ['store', 'update'])) {
            return [];
        }

        if ($actionMethod == 'store') {
            return $this->resource->getCreationRules($this);
        }

        if ($actionMethod == 'update') {
            return $this->resource->getUpdateRules($this);
        }
    }

    /**
     * Get the action.
     *
     * @return \App\Travy\Actions\Action
     */
    public function action($key = null)
    {
        if (! $this->action) {
            $this->action = ActionFactory::make(
                $key ?? $this->route()->getActionMethod(),
                $this,
                $this->resource
            );
        }

        return $this->action;
    }

    /**
     * Get the resource.
     *
     * @return \App\Travy\Resource
     */
    public function resource()
    {
        return $this->resource;
    }

    /**
     * Get the resource id.
     *
     * @return int|string
     */
    public function resourceId()
    {
        return $this->route()->parameter('resourceId');
    }

    /**
     * Get the resource key.
     *
     * @return string
     */
    public function resourceKey()
    {
        return $this->route()->parameter('resource');
    }

    /**
     * Get the relation id.
     *
     * @return int|string
     */
    public function relationId()
    {
        return $this->route()->parameter('relationId');
    }

    /**
     * Get the relation key.
     *
     * @return string
     */
    public function relationKey()
    {
        return $this->route()->parameter('relation');
    }

    /**
     * Get the relation name.
     *
     * @return string
     */
    public function relationName()
    {
        return camel_case($this->relationKey());
    }

    /**
     * Get the relation resource.
     *
     * @return \App\Travy\Resource
     */
    public function relationResource()
    {
        if (! $this->relationResource) {
            $this->relationResource = ResourceFactory::make($this->relationName());
        }

        return $this->relationResource;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->resource = ResourceFactory::make(
            $this->resourceKey()
        );
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return data_get($this->all(), 'data', []);
    }
}
