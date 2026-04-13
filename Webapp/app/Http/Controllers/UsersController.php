<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userrole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
            return redirect()->back()->with('error', e($validator->errors()->all()[0]));
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
            ->with('success', 'User created successfully');
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
            return redirect()->back()->with('error', e($validator->errors()->all()[0]));
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
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()
                ->with('error', 'You cannot delete yourself');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
