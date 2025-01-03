<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Exports\CompanyExport;
use App\Imports\CompanyImport;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{
        public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $companies = Company::query()
            ->when($search, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return view('Company.index', compact('companies', 'search'));
    }


    public function create()
    {
        return view('Company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|string',
            'code' => 'required|max:255|string']);

        Company::create([
            'code'  => $request->code,
            'name' => $request->name,
        ]);
        return redirect()->route('companies.create')->with('success', 'Company created successfully.');
    }

    public function show(Company $companies)
    {
        return view('Company.show', compact('companies'));
    }

    public function edit(int $id)
    {
        $companies = Company::findOrFail($id);
        return view('Company.edit', compact('companies'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([ 
            'name' => 'required|max:255|string',
        'code' => 'required|max:255|string']);
        Company::findOrFail($id)->update([
            'code'  => $request->code,
            'name' => $request->name,
        ]);
        return redirect()->back()->with('status','Company Update');
        }

    public function destroy(int $id)
    {
        $companies=Company::findOrFail($id);
        $companies->delete();

        return redirect()->back()->with('status','Company Deleted');
    }

    public function import(){
        return view('Company.Excelimport');
    }

    
        public function importExcelData(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|file|mimes:xlsx,xls',
            ]);
    
            Excel::import(new CompanyImport, $request->file('import_file'));
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
        
        $filename = 'Company List-'.date('d-m-Y').'.'.$extension;
        return Excel::download(new CompanyExport, $filename,$exportFormat);
    }
}
