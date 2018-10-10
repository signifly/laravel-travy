<?php

namespace Signifly\Travy\FieldTypes;

use Signifly\Travy\Schema\Concerns\HasProps;

abstract class FieldType
{
    use HasProps;

    /**
     * The specific field type.
     *
     * @var string
     */
    protected $id;

    /**
     * The action of the field type.
     *
     * @var string
     */
    protected $action;

    /**
     * Hide the field type.
     *
     * @var array
     */
    protected $hide;

    /**
     * The reference text of the field type.
     *
     * @var string
     */
    protected $reference;

    /**
     * The show property of the field type.
     *
     * @var bool
     */
    protected $show;

    /**
     * The width of the field type.
     *
     * @var int
     */
    protected $width;

    /**
     * Called before building the field type.
     *
     * @return void
     */
    protected function beforeBuild()
    {
    }

    /**
     * Set the action of the field type.
     *
     * @param  string $action
     * @return self
     */
    public function action(string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Build the field type.
     *
     * @return array
     */
    public function build($only = [])
    {
        $this->beforeBuild();

        $schema = [
            'id' => $this->id,
            'action' => $this->action ?: false,
            'props' => $this->props,
        ];

        if ($this->hide) {
            array_set($schema, 'hide', $this->hide);
        }

        if ($this->width) {
            array_set($schema, 'width', $this->width);
        }

        if ($this->show) {
            array_set($schema, 'show', $this->show);
        }

        if ($this->reference) {
            array_set($schema, 'reference', $this->reference);
        }

        return count($only) > 0 ? array_only($schema, $only) : $schema;
    }

    /**
     * Set the disabled prop of the field type.
     *
     * @param  bool $value
     * @return self
     */
    public function disabled($value = true)
    {
        $this->addProp('disabled', $value);

        return $this;
    }

    /**
     * Get the id of the field type.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Hide field type.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string $operator
     * @return self
     */
    public function hide(string $key, $value, string $operator = 'eq')
    {
        $this->hide = compact('key', 'operator', 'value');

        return $this;
    }

    /**
     * Set a reference text.
     *
     * @param  string $reference
     * @return self
     */
    public function reference(string $reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Set the show property.
     *
     * @param  string $show
     * @return self
     */
    public function show(string $show)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Set a width of the field type.
     *
     * @param  int    $width
     * @return self
     */
    public function width(int $width)
    {
        $this->width = $width;

        return $this;
    }
}
