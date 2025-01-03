<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\company;
use App\Models\Department;
use App\Exports\StaffExport;
use App\Imports\StaffImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        // Get request inputs with default value for per_page
        $search = $request->input('search');
        $departmentId = $request->input('department_id');
        $companyId = $request->input('company_id');
        $perPage = $request->input('per_page', 50); // Default to 50 if not specified
    
        // Get all departments and companies for dropdown filters
        $departments = Department::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
    
        // Query staff based on filters
        $staffsQuery = Staff::with(['department', 'company']); // Eager load relationships
    
        // Search filter for specific fields
        if ($search) {
            $staffsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('staff_no', 'like', "%{$search}%")
                      ->orWhere('nric_no', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%");
            });
        }
    
        // Filter by department ID
        if ($departmentId) {
            $staffsQuery->where('department_id', $departmentId);
        }
    
        // Filter by company ID
        if ($companyId) {
            $staffsQuery->where('company_id', $companyId);
        }
    
        // Order by name by default
        $staffsQuery->orderBy('name');
    
        // Paginate the results
        $staff = $staffsQuery->paginate($perPage);
        
        // Append all query parameters to pagination links
        $staff->appends($request->all());
    
        // Pass variables to the view
        return view('Staff.index', compact(
            'staff',
            'search',
            'departments',
            'companies',
            'departmentId',
            'companyId'
        ));
    }

    public function create()
    {
        $departments = Department::all();
        $companies = company::all();
        $staff = Staff::all();
        return view('Staff.create', compact('departments', 'companies', 'staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'nullable|max:255|string',
            'staff_no' => 'nullable|max:255|string',
            'nric_no' => 'nullable|max:255|string',
            'company_id' => 'nullable|integer|exists:company,id',
            'department_id' => 'nullable|integer|exists:department,id',
            'position' => 'nullable|string|max:255',
        
        ]);

        // Create the Asset
        Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'staff_no' => $request->staff_no,
            'nric_no' => $request->nric_no,
            'company_id' => $request->company_id,
            'department_id' => $request->department_id,
            'position' => $request->position,

        ]);

        return redirect()->route('staffs.index')->with('status', 'Staff Created Successfully');
    }


    public function edit(int $id)
    {
        $staff = Staff::findOrFail($id);
        $departments = Department::all();
        $companies = company::all();
        return view('Staff.edit', compact('staff', 'departments', 'companies'));
    }


    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'nullable|max:255|string',
            'staff_no' => 'nullable|max:255|string',
            'nric_no' => 'nullable|max:255|string',
            'company_id' => 'nullable|integer|exists:company,id',
            'department_id' => 'nullable|integer|exists:department,id',
            'position' => 'nullable|string|max:255',
        ]);

        $staff = Staff::findOrFail($id);

        // Update asset details
        $staff->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'staff_no' => $request->input('staff_no'),
            'nric_no' => $request->input('nric_no'),
            'company_id' => $request->input('company_id'),
            'department_id' => $request->input('department_id'),
            'position' => $request->input('position'),
        ]);

        return redirect()->route('staffs.index')->with('status', 'Staff updated successfully.');
    }



    public function destroy(int $id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return redirect()->back()->with('status', 'Staff Deleted Successfully');
    }

public function import(){
    return view('Staff.Excelimport');
}

    public function importExcelData(Request $request)
{
    try {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new StaffImport, $request->file('import_file'));
        return redirect()->back()->with('status', 'Imported Successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Import Failed: ' . $e->getMessage());
    }
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
        
        $filename = 'Staff List-'.date('d-m-Y').'.'.$extension;
        return Excel::download(new StaffExport, $filename,$exportFormat);
    }
}
