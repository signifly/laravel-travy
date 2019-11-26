<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;

abstract class Action implements Arrayable, JsonSerializable
{
    /**
     * The button name of the action.
     *
     * @var string
     */
    protected $name;

    /**
     * The button status / color of the action.
     *
     * @var string
     */
    protected $status;

    /**
     * The button icon of the action.
     *
     * @var string|null
     */
    protected $icon;

    /**
     * The definition for the action type.
     *
     * @var array
     */
    protected $actionType;

    /**
     * Create a new Action.
     *
     * @param string      $name
     * @param string      $status
     * @param string|null $icon
     */
    public function __construct(
        string $name,
        string $status = 'primary',
        ?string $icon = null
    ) {
        $this->name = $name;
        $this->status = $status;
        $this->icon = $icon;
    }

    /**
     * Initialize the action statically.
     *
     * @param  mixed $arguments
     * @return self
     */
    public static function make(...$arguments): self
    {
        return new static(...$arguments);
    }

    /**
     * The action type.
     *
     * @return array
     */
    abstract public function actionType(): array;

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $schema = new Schema([
            'name' => $this->name,
            'status' => $this->status,
            'icon' => $this->icon,
            'actionType' => $this->actionType(),
        ]);

        return $schema->toArray();
    }
}
