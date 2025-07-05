<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Spatie\Permission\Models\Role;


class UserManagementController extends Controller
{
    public function index(){
        return view('role-management.index');
    }

    public function AddUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user,encoder,staff',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the user (DO NOT store role here — Spatie handles it)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Assign role using Spatie
        $user->assignRole($request->role);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(), // ['admin']
            ]
        ], 201);
    }

    public function getRoles()
    {
        return response()->json(Role::select('name')->get());
    }

    public function userDetails()
    {
        $users = User::with('roles:id,name') // eager load roles, select only id and name
                    ->select('id', 'name', 'email', 'status')
                    ->get();

        return response()->json([
            'status' => true,
            'users' => $users
        ]);
    }

    public function UpdateUser(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'role' => 'required|in:admin,user,encoder,staff',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // ✅ Update the user's role using Spatie
        $user->syncRoles([$request->role]);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(), // returns a collection like ['admin']
            ]
        ]);
    }

    public function activityLogs(Request $request)
    {
        if ($request->ajax()) {
            $logs = DB::table('activity_logs')
                ->leftJoin('users', 'activity_logs.user_id', '=', 'users.id')
                ->select(
                    'activity_logs.id',
                    'activity_logs.user_id',
                    'users.name',
                    'activity_logs.description',
                    'users.role',
                    'users.email_verified_at',
                    'activity_logs.created_at',
                    'activity_logs.updated_at'
                )
                ->orderByDesc('activity_logs.id')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logs
            ]);
        }

        return view('activityLogs.activity_log');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        // Soft delete: just mark inactive
        $user->status = 0;
        $user->save();

        return response()->json(['status' => true, 'message' => 'User deleted (deactivated) successfully.']);
    }

    public function restoreUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $user->status = 1;
        $user->save();

        return response()->json(['status' => true, 'message' => 'User restored successfully.']);
    }
}
