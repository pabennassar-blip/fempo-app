<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoginConfig;
use Illuminate\Http\Request;

class LoginConfigController extends Controller
{
    /**
     * Obté la configuració del login per a la clau especificada.
     * Endpoint públic: no requereix autenticació.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $key = $request->query('key', 'default');
        $config = LoginConfig::getConfig($key);

        return response()->json([
            'config' => $config,
        ]);
    }
}
