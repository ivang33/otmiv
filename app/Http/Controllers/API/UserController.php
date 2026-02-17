<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with(['role', 'laundryItems', 'orders'])->get();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'email' => 'required|string|email|max:30|unique:users',
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:70',
            'role_id' => 'required|exists:roles,id',
            'avatar' => 'nullable|string|max:150',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user->load('role')
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user->load(['role', 'laundryItems', 'orders', 'messages'])
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:70',
            'email' => 'sometimes|string|email|max:30|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6',
            'address' => 'sometimes|string|max:70',
            'role_id' => 'sometimes|exists:roles,id',
            'avatar' => 'nullable|string|max:150',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user->load('role')
        ]);
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Check if user has related records
        if ($user->laundryItems()->count() > 0 || $user->orders()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete user with existing laundry items or orders'
            ], Response::HTTP_CONFLICT);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Get user's laundry items.
     */
    public function laundryItems(User $user)
    {
        $items = $user->laundryItems()->with(['category', 'status'])->get();

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    /**
     * Get user's orders.
     */
    public function orders(User $user)
    {
        $orders = $user->orders()->with(['status', 'pickupPoint'])->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Update user profile (for authenticated user).
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:70',
            'address' => 'sometimes|string|max:70',
            'avatar' => 'nullable|string|max:150',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Change user password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
