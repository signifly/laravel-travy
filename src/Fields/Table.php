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
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Set the columnsData prop.
     *
     * @param  string  $data
     * @return self
     */
    public function data(string $data): self
    {
        return $this->withProps(['columnsData' => $data]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps([
            'columns' => $this->preparedColumns(),
        ]);
    }
}
