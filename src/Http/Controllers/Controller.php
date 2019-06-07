<?php

namespace Signifly\Travy\Http\Controllers;

use Signifly\Pagination\Pagination;
use Signifly\Responder\Concerns\Respondable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use DispatchesJobs;
    use ValidatesRequests;
    use AuthorizesRequests;
    use Respondable;

    public function __construct()
    {
        $this->middleware(Pagination::class)->only('index');
    }
}
