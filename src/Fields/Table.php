<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\Schema\Concerns\HasColumns;

class Table extends Field
{
    use HasColumns;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'table';

    /**
     * Set the columnsData prop.
     *
     * @param  array  $data
     * @return self
     */
    public function data(array $data)
    {
        return $this->withMeta(['columnsData' => $data]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta([
            'columns' => $this->preparedColumns(),
        ]);
    }
}
