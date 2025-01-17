<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    // Display list of users
    public function index(Request $request)
    {
        $search = $request->input('search'); // Capture the search term
        $perPage = $request->input('per_page', 50); // Set pagination limit, default is 50
    
        // Query for users
        $users = User::query()
            ->with(['role', 'department']) // Eager load relationships
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%") // Search by name
                    ->orWhere('email', 'like', "%{$search}%") // Search by email
                    ->orWhereHas('role', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%"); // Search in roles
                    })
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%"); // Search in departments
                    });
            })
            ->paginate($perPage); // Paginate the results
    
        return view('User.index', compact('users')); // Pass the users to the view
    }
    


    // Show form to create a new user
    public function create()
    {
        $department = Department::all();
        $roles = Role::all(); // Fetch all roles
        return view('User.create', compact('department','roles'));
    }

    // Store a new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roleid' => 'required|integer',
            'department_id' => 'nullable|exists:department,id',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roleid' => $request->roleid,
            'department_id' => $request->department_id,
        ]);
    
        // Redirect to the edit page for the newly created user
        return redirect()->route('users.create', $user->id)->with('success', 'User created successfully.');
    }    

    // Show form to edit an existing user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all(); // Fetch all departments
        $roles = Role::all(); // Fetch all roles

        // dd($user, $departments, $roles); // Temporary debugging statement

    return view('User.edit', compact('user', 'departments', 'roles'));
    }

        // Update user details
        public function update(Request $request,int $id)
        {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'roleid' => 'required|integer|exists:roles,id',
                'department_id' => 'nullable|exists:department,id',
                'password' => 'nullable|string|min:8|confirmed', // Add password validation
            ]);

            $data = $request->only(['name', 'email', 'roleid', 'department_id']);

            // Check if password is provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password); // Hash the password
            }

            $user->update($data);

            return redirect()->route('users.edit', $id)->with('success', 'User updated successfully.');
        }
        


    // Delete a user
    public function destroy(int $id)
    {
        $user=User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('status','User Deleted');
    }

    public function export(Request $request) 
    {
        if($request->type == "xslsx"){
            $extension = "xlsx";
            $exportFormat =  \Maatwebsite\Excel\Excel::XLSX;

        }elseif($request->type == "csv"){
            $extension = "csv";
            $exportFormat =  \Maatwebsite\Excel\Excel::CSV;

        }elseif($request->type == "xls"){
            $extension = "xls";
            $exportFormat =  \Maatwebsite\Excel\Excel::XLS;

        }else{
            $extension = "xlsx";
            $exportFormat =  \Maatwebsite\Excel\Excel::XLSX;
            
        }
        
        $filename = 'User List-'.date('d-m-Y').'.'.$extension;
        return Excel::download(new UserExport, $filename,$exportFormat);
    }

    
}
