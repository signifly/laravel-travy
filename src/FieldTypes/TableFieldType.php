<?php

namespace Signifly\Travy\FieldTypes;

use Signifly\Travy\Schema\Concerns\HasColumns;

class TableFieldType extends FieldType
{
    use HasColumns;

    protected $id = 'vTable';

    protected function beforeBuild()
    {
        $this->addProp('columns', $this->preparedColumns());
    }
}
