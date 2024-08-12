<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Hash;
use Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->has('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }
        if ($request->has('gender')) {
            $query->where('gender', $request->input('gender'));
        }
        if ($request->has('date_of_birth')) {
            $query->whereDate('date_of_birth', $request->input('date_of_birth'));
        }

        $users = $query->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:users,id',
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'date_of_birth' => 'date',
            'gender' => 'in:male,female,other',
            'email' => 'email|unique:users,email,' . $request->input('id'),
            'password' => 'min:6',
        ]);

        $user = User::findOrFail($validatedData['id']);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);
        return response()->json($user);
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            //'id' => 'required|exists:users,id',
            'id' => 'required|integer',
        ]);

        try {
            $user = User::findOrFail($validatedData['id']);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // This will be caught if the user is not found
            Log::error('ModelNotFoundException: ' . $e->getMessage());
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            // This will catch any other exceptions that might occur
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the user'], 500);
        }
    }
}
