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
        $this->middleware(JwtCookieAuth::class, ['except' => ['login']]);
    }

    /**
     * Login and set JWT in HttpOnly cookie
     */
    public function login(Request $request)
    {
        $credentials = $request->only('employee_code', 'password');

        if (!$token = auth()->attempt($credentials)) {
            redirect("/login");
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
     * Store a newly created user
     */
    // TODO: Move to user controller
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'first_name' => 'nullable|string|max:45',
            'initials' => 'nullable|string|max:12',
            'prefix' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:100|unique:users',
            'employee_code' => 'required|string|max:10',
            'user_role' => 'required|integer|exists:userroles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'initials' => $request->initials,
            'prefix' => $request->prefix,
            'email' => $request->email,
            'employee_code' => $request->employee_code,
            'user_role' => $request->user_role,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
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

        return redirect("/")->cookie($cookie);
    }

}
