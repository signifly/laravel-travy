<?php

namespace Signifly\Travy\FieldTypes;

use Closure;
use Signifly\Travy\Concerns\HasColumns;

class TableFieldType extends FieldType
{
    use HasColumns;

    protected $id = 'vTable';

    protected function beforeBuild()
    {
        $this->addProp('columns', $this->preparedColumns());
    }
}
