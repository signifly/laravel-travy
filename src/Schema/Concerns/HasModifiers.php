<?php

namespace Signifly\Travy\Schema\Concerns;

use Exception;
use Signifly\Travy\Schema\Modifier;

trait HasModifiers
{
    /**
     * The modifiers array.
     *
     * @var array
     */
    protected $modifiers = [];

    /**
     * Add tab to the definition schema.
     *
     * @param string $key
     * @param string $title
     *
     * @return \Signifly\Travy\Modifier
     */
    public function addModifier($key, $title)
    {
        $modifier = new Modifier($key, $title);

        array_push($this->modifiers, $modifier);

        return $modifier;
    }

    /**
     * Add modifier from a callable definition.
     *
     * @param string $modifier
     */
    public function addModifierFor(string $modifier)
    {
        $class = new $modifier();

        if (!is_callable($class)) {
            throw new Exception($modifier.' must be callable.');
        }

        return $class($this);
    }

    /**
     * Determine if there are any modifiers.
     *
     * @return bool
     */
    public function hasModifiers()
    {
        return count($this->modifiers) > 0;
    }

    /**
     * Get the prepared modifiers.
     *
     * @return array
     */
    protected function preparedModifiers()
    {
        return collect($this->modifiers)->map->toArray();
    }
}
