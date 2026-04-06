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
            ->join('userroles', 'users.id', '=', 'userroles.id')
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

        return view('users.create', compact('userroles'));
    }

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

        $data = $request->all();
        $data['name'] = $data['name'] ?? '';
        $data['email'] = $data['email'] ?? '';
        $data['employee_code'] = $data['employee_code'] ?? '';
        $data['user_role'] = $data['user_role'] ?? 0;
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $userroles = Userrole::all();

        return view('users.edit', compact('user', 'userroles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'first_name' => 'nullable|string|max:45',
            'initials' => 'nullable|string|max:12',
            'prefix' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:100',
            'employee_code' => 'required|string|max:10',
            'user_role' => 'required|integer|exists:userroles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update($request->only([
            'name',
            'first_name',
            'initials',
            'prefix',
            'email',
            'employee_code',
            'user_role',
            'password',
        ]));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
