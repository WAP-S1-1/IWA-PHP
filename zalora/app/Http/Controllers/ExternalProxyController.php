<?php

namespace App\Http\Controllers;

use App\Services\ExternalApiService;
use Illuminate\Http\Request;

class ExternalProxyController extends Controller
{
    public function __invoke(Request $request, ExternalApiService $api)
    {
        $path = ltrim(str_replace('api/', '', $request->path()), '/');
        error_log($path);

        return $api->request(
            $request->method(),
            $path,
        );
    }
}
