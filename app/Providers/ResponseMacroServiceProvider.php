<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('axios', function($value) {
            return Response::json($value, 200)->withHeaders([
                'Content-type' => 'application/json;charset=UTF-8',
                'Charset' => 'utf-8'
            ]);
        });
    }
}
