<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userrole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Laravel\Prompts\select;

class UsersController extends Controller {

    public function index(Request $request)
    {
        $users = DB::table('users')
            ->join('userroles', 'users.user_role', '=', 'userroles.id')
            ->select('*',
            'users.id as user_id')
            ->orderBy('users.id')
            ->get();

        $mode = $request->query('mode');

        return view('users.index', compact('users', 'mode'));
    }

    public function create()
    {
        $userroles = Userrole::all();

        return view('users/create', compact('userroles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'first_name' => 'nullable|string|max:45',
            'initials' => 'nullable|string|max:12',
            'prefix' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:100|unique:users',
            'employee_code' => 'required|string|max:10|unique:users',
            'user_role' => 'required|integer|exists:userroles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('email')) {
                return redirect()->back()->with('error', 'Dit e-mailadres bestaat al');
            }

            if ($errors->has('employee_code')) {
                return redirect()->back()->with('error', 'Dit personeelscode bestaat al');
            }

            if ($errors->has('password')) {
                return redirect()->back()->with('error', 'De bevestiging van het wachtwoord komt niet overeen');
            }
        }

        User::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'initials' => $request->initials,
            'prefix' => $request->prefix,
            'email' => $request->email,
            'employee_code' => $request->employee_code,
            'user_role' => $request->user_role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Gebruiker aangemaakt');
    }

    public function edit(User $user)
    {
        $userroles = Userrole::all();

        return view('users/edit', compact('user', 'userroles'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'first_name' => 'nullable|string|max:45',
            'initials' => 'nullable|string|max:12',
            'prefix' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'employee_code' => 'required|string|max:10|unique:users,employee_code,' . $user->id,
            'user_role' => 'required|integer|exists:userroles,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('email')) {
                return redirect()->back()->with('error', 'Dit e-mailadres bestaat al');
            }

            if ($errors->has('employee_code')) {
                return redirect()->back()->with('error', 'Dit personeelscode bestaat al');
            }
        }

        $user->update($request->only([
            'name',
            'first_name',
            'initials',
            'prefix',
            'email',
            'employee_code',
            'user_role',
        ]));

        return redirect()->route('users.index')
            ->with('success', 'Gebruiker gewijzigd');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()
                ->with('error', 'Je kan jezelf niet verwijderen!');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Gebruiker verwijderd');
    }

    public function editPassword(User $user)
    {
        return view('users.password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $currentUser = auth()->user();

        if (!in_array($currentUser->user_role, [4, 6]) && $currentUser->id !== $user->id) {
            return redirect()->back()
                ->with('error', 'Je mag dit wachtwoord niet wijzigen');
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', "Wachtwoord moet minimaal 8 karakters lang zijn, en de wachtwoorden moeten overeen komen");
        }

        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Nieuw wachtwoord is hetzelfde als het oude wachtwoord');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        if ($currentUser->id === $user->id) {
            $token = $request->cookie('jwt-token');
            if ($token) {
                JWTAuth::setToken($token)->invalidate();
            }

            // Remove cookie
            $cookie = cookie('jwt-token', '', -1);

            $response = redirect('/login')
                ->with('success', 'Wachtwoord gewijzigd, log opnieuw in')
                ->cookie($cookie);

            return $response->cookie('token', '', -1);
        }

        return redirect()->route('users.index')
            ->with('success', 'Wachtwoord gewijzigd');
    }
}
