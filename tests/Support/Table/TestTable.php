<?php

namespace Signifly\Travy\Test\Support\Table;

use Signifly\Travy\Fields\Text;
use Signifly\Travy\Schema\Table;
use Signifly\Travy\Schema\Endpoint;

class TestTable extends Table
{
    public function columns(): array
    {
        return [
            Text::make('Title')
                ->sortable(),
        ];
    }

    public function endpoint(): Endpoint
    {
        return new Endpoint('some_url');
    }
}
