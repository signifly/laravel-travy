<?php

namespace Signifly\Travy\Http\Controllers;

use Illuminate\Routing\Controller;
use Signifly\Travy\Support\DashboardFactory;

class DashboardController extends Controller
{
    public function show($name)
    {
        return DashboardFactory::make($name);
    }
}
