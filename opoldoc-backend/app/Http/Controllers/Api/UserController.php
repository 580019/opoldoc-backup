<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'patientProfile', 'doctorProfile'])
            ->orderBy('user_id')
            ->get();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,role_id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
            'first_name' => ['required', 'string', 'max:50'],
            'middle_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'role_id' => $validated['role_id'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'] ?? null,
        ]);

        return response()->json($user->load(['role', 'patientProfile', 'doctorProfile']), 201);
    }

    public function show(User $user)
    {
        return response()->json($user->load(['role', 'patientProfile', 'doctorProfile']));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => ['sometimes', 'integer', 'exists:roles,role_id'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,'.$user->user_id.',user_id'],
            'password' => ['sometimes', 'string', 'min:6', 'max:255'],
            'first_name' => ['sometimes', 'string', 'max:50'],
            'middle_name' => ['sometimes', 'nullable', 'string', 'max:50'],
            'last_name' => ['sometimes', 'string', 'max:50'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
        ]);

        if (array_key_exists('password', $validated)) {
            $validated['password_hash'] = Hash::make($validated['password']);
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json($user->load(['role', 'patientProfile', 'doctorProfile']));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['deleted' => true]);
    }
}
