<?php

namespace App\Http\Controllers;

use App\Http\Middleware\JwtCookieAuth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(JwtCookieAuth::class, ['except' => ['login']]);
    }

    /**
     * Login and set JWT in HttpOnly cookie
     */
    public function login(Request $request)
    {
        $credentials = $request->only('employee_code', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return redirect("/login")->with('error', 'Verkeerd wachtwoord of personeelscode bestaat niet');
            //return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithCookie($token);
    }

    /**
     * Respond with JWT as HttpOnly cookie
     */
    protected function respondWithCookie(string $token)
    {
        // Create HttpOnly cookie, 1 day expiration
        $cookie = cookie('jwt-token', $token, 60*24, null, null, false, true);

        return redirect("/")->cookie($cookie);
    }

    /**
     * Get the authenticated user's profile
     */
    public function profile(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $user = JWTAuth::setToken($token)->authenticate();

        return response()->json($user);
    }

    /**
     * Logout and remove cookie
     */
    public function logout(Request $request)
    {
        $token = $request->cookie('jwt-token');
        if ($token) {
            JWTAuth::setToken($token)->invalidate();
        }

        // Remove cookie
        $cookie = cookie('jwt-token', '', -1);

        return redirect("/login")->cookie($cookie);
    }
}
