<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use App\Models\Role; // Import Role model if using role relationship
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // For hashing passwords
use Illuminate\Validation\Rule; // For unique email validation
use Illuminate\Support\Facades\Auth; // <-- ADD THIS LINE

class UserController extends Controller
{
    /**
     * @var \App\Models\User|null The currently authenticated user.
     * This helps Intelephense understand the type when using auth()->user().
     */
    protected $currentUser;

    public function __construct()
    {
        // You might want to apply middleware here, for example:
        // $this->middleware('auth');
        // $this->middleware('admin'); // If only admins can manage users

        // Optionally, for better type hinting of Auth::user() later,
        // though Intelephense usually handles it better with the facade imported.
        $this->currentUser = Auth::user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load roles if the User model has a 'role' relationship
        $users = User::with('role')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Get all available roles for assignment
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' checks for password_confirmation field
            // Assuming 'role' is a string field in User model as per your definition
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')], // Validate 'role_id' references 'id' in 'roles' table
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password!
            'role_id' => $request->role_id, // Use role_id for consistency with User model
            'is_active' => $request->is_active ?? true, // Default to active if not provided
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('role'); // Eager load role for display
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Unique email, ignore current user's ID
            'password' => 'nullable|string|min:8|confirmed', // Password is optional for update
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')], // Validate 'role_id' references 'id' in 'roles' table
            'is_active' => 'boolean',
        ]);

        $userData = $request->except('password', 'password_confirmation');

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Use Auth facade for explicit type hinting for IDE
        if (Auth::check() && Auth::user()->id === $user->id) { // <-- Use Auth facade here
            return redirect()->back()->withErrors('You cannot delete your own account while logged in.');
        }

        // Consider cascading deletes for related data (e.g., articles, diagnoses)
        // If your database uses foreign key cascades, this might be handled automatically.
        // Otherwise, manually delete related records if they should not persist:
        // $user->articles()->delete();
        // $user->diagnosas()->delete();

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}