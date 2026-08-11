<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Constituency;
use App\Models\Corporation;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of AGM and DGM users only.
     */
    public function index()
    {
        $users = User::role(['agm', 'dgm'])->with('roles')->latest()->paginate(15);
        return view('admin.masters.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $corporations = Corporation::orderBy('name')->get();
        $constituencies = Constituency::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.masters.users.create', compact('corporations', 'constituencies', 'roles'));
    }

    /**
     * Store a newly created user in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:users,mobile_number',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:4',
            'role' => 'required|string|in:agm,dgm',
            'corporation' => 'required_if:role,dgm|array',
            'constituency' => 'required_if:role,agm|array',
        ]);

        $role = $request->role;
        $corporationIds = ($role === 'dgm') ? array_map('intval', $request->input('corporation', [])) : null;
        $constituencyIds = ($role === 'agm') ? array_map('intval', $request->input('constituency', [])) : null;

        $user = User::create([
            'name' => $request->name,
            'mobile_number' => $request->phone,
            'email' => strtolower(trim($request->email)),
            'password' => bcrypt($request->password),
            'corporation_ids' => $corporationIds,
            'constituency_ids' => $constituencyIds,
        ]);

        // Assign Spatie Role
        $spatieRole = Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        $user->syncRoles([$spatieRole]);

        return redirect()->route('admin.masters.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user details.
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('admin.masters.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $corporations = Corporation::orderBy('name')->get();
        $constituencies = Constituency::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.masters.users.edit', compact('user', 'corporations', 'constituencies', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:users,mobile_number,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:agm,dgm',
            'corporation' => 'required_if:role,dgm|array',
            'constituency' => 'required_if:role,agm|array',
        ]);

        $role = $request->role;
        $corporationIds = ($role === 'dgm') ? array_map('intval', $request->input('corporation', [])) : null;
        $constituencyIds = ($role === 'agm') ? array_map('intval', $request->input('constituency', [])) : null;

        $userData = [
            'name' => $request->name,
            'mobile_number' => $request->phone,
            'email' => strtolower(trim($request->email)),
            'corporation_ids' => $corporationIds,
            'constituency_ids' => $constituencyIds,
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData);

        // Sync Spatie Role
        $spatieRole = Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        $user->syncRoles([$spatieRole]);

        return redirect()->route('admin.masters.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.masters.users.index')->with('success', 'User removed successfully!');
    }
}
