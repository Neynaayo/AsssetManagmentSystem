<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Department;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $department = Department::all(); // Fetch all departments
        return view('auth.register', compact('department'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
        {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'department_id' => 'nullable|exists:department,id',
                'new_department' => 'nullable|string|max:255',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            // Determine department ID
            $departmentId = null;
            if ($request->filled('new_department')) {
                // Check if a department with the same name exists
                $newDepartment = Department::firstOrCreate(['name' => $request->new_department]);
                $departmentId = $newDepartment->id;
            } else {
                $departmentId = $request->department_id;
            }

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'roleid' => 2,
                'department_id' => $departmentId,
            ]);

            event(new Registered($user));

            // Redirect to login page with a success message
            return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
        }

}
