<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getViewResponse($viewName, $viewPath, bool $error, array $data=[])
    {
        return response()->axios([
            'error' => $error,
            $viewName => View::make($viewPath, $data)->render(),
        ]);
    }
}
