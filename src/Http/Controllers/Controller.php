<?php

namespace Signifly\Travy\Http\Controllers;

use Signifly\Pagination\Pagination;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Signifly\Travy\Http\Concerns\HandlesApiResponses;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
