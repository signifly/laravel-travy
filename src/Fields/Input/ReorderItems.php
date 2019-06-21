<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Concerns\HasActions;
use Signifly\Travy\Schema\Concerns\HasEndpoint;

class ReorderItems extends Field
{
    use HasActions;
    use HasEndpoint;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-reorder-items';

    /**
     * Set the items.image prop.
     *
     * @param  string $key
     * @return self
     */
    public function image(string $key): self
    {
        return $this->setProp('items.image', $key);
    }

    /**
     * Set the items.list prop.
     *
     * @param  array<label, value>  $list
     * @return self
     */
    public function list(array $list): self
    {
        return $this->setProp('items.list', $list);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->setProp('items.data', $this->attribute);
        $this->setProp('items.actions', $this->preparedActions());
        $this->setProp('endpoint', $this->endpoint->toArray());
    }
}
