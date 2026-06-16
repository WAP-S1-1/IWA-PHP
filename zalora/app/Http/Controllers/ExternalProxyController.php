<?php

namespace App\Http\Controllers;

use App\Services\ExternalApiService;
use Illuminate\Http\Request;

class ExternalProxyController extends Controller
{
    public function __invoke(Request $request, ExternalApiService $api)
    {
        // Prepare path for api request (strip api/ and remove / in front)
        $path = ltrim(str_replace('api/', '', $request->path()), '/');

        $data = $request->all();

        return $api->request(
            $request->method(),
            $path,
            $data
        );
    }
}
