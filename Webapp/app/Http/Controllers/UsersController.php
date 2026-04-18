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

    const ROLE_PREFIXES = [
        1 => 'T',  // Technisch medewerker
        2 => 'O',  // Technisch onderzoeker
        3 => 'C',  // Commercieel medewerker
        4 => 'AD',  // Administratief medewerker
        5 => 'B',  // Technisch beheerder
        6 => 'A',  // Administrator
    ];

    public function getPrefix(Request $request)
    {
        $roleId = $request->input('user_role');
        $existingCode = $request->input('employee_code');
        $newPrefix = self::ROLE_PREFIXES[$roleId] ?? '';
        $numbers = preg_replace('/[^0-9]/', '', $existingCode);
        $value = !empty($numbers) ? htmlspecialchars($newPrefix . $numbers) : htmlspecialchars($newPrefix);

        return '<input type="text" class="form-control" id="employee_code" name="employee_code" value="' . $value . '" required>';
    }


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


// In store() method, update the validator:
        $validator = Validator::make($request->all(), [
            // ... other rules ...
            'employee_code' => 'required|string|max:10|unique:users|starts_with:' . (self::ROLE_PREFIXES[$request->user_role] ?? ''),
            // ... other rules ...
        ]);


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

        // In update() method, update the validator similarly:
        $validator = Validator::make($request->all(), [
            'employee_code' => 'required|string|max:10|unique:users,employee_code,' . $user->id . '|starts_with:' . (self::ROLE_PREFIXES[$request->user_role] ?? ''),

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
            'user_role',
            'unique:users,employee_code,' . ($user->id ?? ''),
            function ($attribute, $value, $fail) use ($request) {
                $expectedPrefix = self::ROLE_PREFIXES[$request->user_role] ?? null;
                if (!$expectedPrefix || !str_starts_with(strtoupper($value), $expectedPrefix)) {
                    $fail("The employee code must start with '{$expectedPrefix}' for this role.");
                }
            }

        ]));

        return redirect()->route('users.index')
            ->with('success', 'User geüpdate');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()
                ->with('error', 'Je kan jezelf niet verwijderen');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User verwijderd');
    }
}
