<?php

namespace Signifly\Travy\Schema\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Signifly\Travy\Exceptions\InvalidPropsException;

trait HasProps
{
    /**
     * The props for the element.
     *
     * @var array
     */
    protected $props = [];

    protected $propsValidationRules = [];

    /**
     * Forget a given prop.
     *
     * @param  string|array $key
     * @return void
     */
    public function forgetProp($key)
    {
        return Arr::forget($this->props, $key);
    }

    /**
     * Get a specific prop.
     *
     * @param  string $key
     * @return mixed
     */
    public function getProp(string $key)
    {
        return Arr::get($this->props, $key);
    }

    /**
     * Check if a given prop exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasProp(string $key)
    {
        return Arr::has($this->props, $key);
    }

    /**
     * Get the props for the element.
     *
     * @return array
     */
    public function props()
    {
        return $this->props;
    }

    /**
     * Set the prop by key and value.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setProp(string $key, $value): self
    {
        Arr::set($this->props, $key, $value);

        return $this;
    }

    /**
     * Set additional props for the element.
     *
     * @param  array  $props
     * @return $this
     */
    public function withProps(array $props): self
    {
        $this->props = array_merge($this->props, $props);

        return $this;
    }

    public function guardAgainstInvalidProps(array $props)
    {
        $validator = Validator::make($props, $this->propsValidationRules);

        if ($validator->fails()) {
            throw new InvalidPropsException($validator->errors());
        }
    }
}
