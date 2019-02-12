<?php

namespace Signifly\Travy\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Signifly\Pagination\Pagination;
use Signifly\Travy\Http\Concerns\HandlesApiResponses;

class Controller extends BaseController
{
    use DispatchesJobs;
    use ValidatesRequests;
    use AuthorizesRequests;
    use HandlesApiResponses;

    public function __construct()
    {
        $this->middleware(Pagination::class)->only('index');
    }
}
