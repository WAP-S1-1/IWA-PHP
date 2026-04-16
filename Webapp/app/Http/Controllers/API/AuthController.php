<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Get credentials from request
        $credentials = $request->only('email', 'password');

        // Uses the customer-api auth and attempts to log in with the given credentials
        if (!$token = auth('customer-api')->attempt($credentials)) {
            // If not successful (null) return  401
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        // Login successful so return token
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'customer' => auth('customer-api')->user()
        ]);
    }
}
