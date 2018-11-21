<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Schema\Concerns\HasColumns;

class SelectMultiSearchTable extends SelectMultiSearch
{
    use HasColumns;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-select-multi-search-table';

    /**
     * Set the columnsDataOverwrite prop.
     *
     * @param  array  $data
     * @return self
     */
    public function data(array $data)
    {
        return $this->withMeta(['columnsDataOverwrite' => $data]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta([
            'values' => $this->attribute,
            'columns' => $this->preparedColumns(),
        ]);
    }
}
