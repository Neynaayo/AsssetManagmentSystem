<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Exports\DepartmentExport;
use App\Imports\DepartmentImport;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $departments = Department::query()
            ->when($search, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return view('Department.index', compact('departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('Department.create',compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|string',
            'code' => 'required|max:255|string']);

            Department::create([
            'code'  => $request->code,
            'name' => $request->name,
        ]);
        return redirect()->route('departments.create')->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        return view('Department.show', compact('department'));
    }

    public function edit(int $id)
    {
        $department = Department::findOrFail($id);
        return view('Department.edit', compact('department'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([ 
            'name' => 'required|max:255|string',
            'code' => 'required|max:255|string']);
        Department::findOrFail($id)->update([
            'code'  => $request->code,
            'name' => $request->name,
        ]);
        return redirect()->back()->with('status','Department Update');
    }

    public function destroy(int $id)
    {
        $departments=Department::findOrFail($id);
        $departments->delete();
        return redirect()->back()->with('success', 'Department deleted successfully.');
    }

    public function import(){
        return view('Department.Excelimport');
    }
    
        public function importExcelData(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|file|mimes:xlsx,xls',
            ]);
    
            Excel::import(new DepartmentImport, $request->file('import_file'));
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
        
        $filename = 'Department List-'.date('d-m-Y').'.'.$extension;
        return Excel::download(new DepartmentExport, $filename,$exportFormat);
    }
}
