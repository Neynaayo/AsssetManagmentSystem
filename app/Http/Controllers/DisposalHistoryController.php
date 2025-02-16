<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Staff;
use App\Models\History;
use Illuminate\Http\Request;
use App\Models\DisposalStatus;
use App\Exports\DisposalExport;
use App\Imports\DisposalImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DisposalHistoryController extends Controller
{
   // Display the list of loans


public function index(Request $request)
{
    // Capture filters
    $search = $request->input('search');
    $selectedStatus = $request->input('disposal_status_id');
    $selectedYear = $request->input('year');
    $selectedMonth = $request->input('month');
    $perPage = $request->input('per_page', 10); // Default to 10 items per page

    // Build query for disposals
    $disposals = History::where('status', 'Disposal')
        ->when($selectedStatus, function ($query, $selectedStatus) {
            return $query->where('disposal_status_id', $selectedStatus);
        })
        ->when($selectedYear, function ($query, $selectedYear) {
            return $query->whereYear('date_loan', $selectedYear);
        })
        ->when($selectedMonth, function ($query, $selectedMonth) {
            return $query->whereMonth('date_loan', $selectedMonth);
        })
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('remark', 'like', "%{$search}%")
                      ->orWhereHas('asset', function ($assetQuery) use ($search) {
                          $assetQuery->where('asset_name', 'like', "%{$search}%")
                                     ->orWhere('brand', 'like', "%{$search}%")
                                     ->orWhere('model', 'like', "%{$search}%")
                                     ->orWhere('location', 'like', "%{$search}%")
                                     ->orWhere('serial_number', 'like', "%{$search}%")
                                     ->orWhere('spec', 'like', "%{$search}%");
                      });
            });
        })
        ->with('disposalStatus', 'asset') // Ensure relationships are eager loaded
        ->paginate($perPage);

    // Prepare filter options
    $statuses = DisposalStatus::all();
    $years = History::selectRaw('YEAR(date_loan) as year')->distinct()->pluck('year');
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    // Return view with data
    return view('Disposal.index', compact(
        'disposals', 'statuses', 'years', 'months',
        'selectedStatus', 'selectedYear', 'selectedMonth', 'search'
    ));
}


   

   // Show the form to create a new loan
   public function create()
   {
        $asset = Asset::all();
        $staff = Staff::all();
        $statuses = DisposalStatus::all();
       return view('Disposal.create',compact('statuses','asset','staff'));
   }

   // Store a new loan in the database
   public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'nullable|exists:assets,id',
            'manual_asset_name' => 'nullable|string|max:255',
            'manual_brand' => 'nullable|string|max:255',
            'manual_model' => 'nullable|string|max:255',
            'manual_location' => 'nullable|string|max:255',
            'manual_serial_number' => 'nullable|string|max:255',
            'manual_spec' => 'nullable|string|max:255',
            'date_loan' => 'nullable|date',
            'disposal_status_id' => 'required|exists:disposal_statuses,id',
            'remark' => 'nullable|string|max:255',
        ]);

        // Handle asset
        $assetId = $request->input('asset_id');
        if (!$assetId && $request->filled(['manual_asset_name', 'manual_brand', 'manual_model'])) {
            $asset = Asset::create([
                'asset_name' => $request->input('manual_asset_name'),
                'brand' => $request->input('manual_brand'),
                'model' => $request->input('manual_model'),
                'location' => $request->input('manual_location'),
                'serial_number' => $request->input('manual_serial_number'),
                'spec' => $request->input('manual_spec'),
            ]);
            $assetId = $asset->id;
            // Log the asset creation
            Log::info('New asset created: ', ['id' => $assetId]);
        }

        if (!$assetId) {
            return redirect()->back()->withErrors(['asset' => 'Failed to create or find an asset']);
        }

        // Create disposal history
        History::create([
            'asset_id' => $assetId,
            'date_loan' => $request->input('date_loan'),
            'disposal_status_id' => $request->input('disposal_status_id'),
            'status' => 'Disposal',
            'remark' => $request->input('remark'),
        ]);

        return redirect()->route('disposals.create')->with('status', 'Disposal asset created successfully.');
}

   // Show the form to edit an existing loan
   public function edit(int $id)
   {
       $disposals = History::findOrFail($id);
       $asset = Asset::all();
        $staff = Staff::all();
        $statuses = DisposalStatus::all();
        // If the selected asset is linked to this available record
        $selectedAsset = $disposals->asset_id ? Asset::find($disposals->asset_id) : null;
       return view('Disposal.edit', compact('statuses','disposals','staff','asset','selectedAsset'));
   }

   // Update an existing loan in the database
   public function update(Request $request, int $id)
   {
       // Validate the request data
       $request->validate([
        'asset_id' => 'nullable|exists:assets,id',
        'manual_asset_name' => 'nullable|string|max:255',
        'manual_brand' => 'nullable|string|max:255',
        'manual_model' => 'nullable|string|max:255',
        'manual_location' => 'nullable|string|max:255',
        'manual_serial_number' => 'nullable|string|max:255',
        'manual_spec' => 'nullable|string|max:255',
        // 'loan_by' => 'nullable|exists:staff,id',
        // 'manual_loan_by' => 'nullable|string|max:255',
        'disposal_status_id' => 'required|exists:disposal_statuses,id',
        'date_loan' => 'nullable|date',
        // 'until_date_loan' => 'required|date|after:date_loan',
        'remark' => 'nullable|string|max:255',
    ]);

    $Disposals = History::findOrFail($id);

    // Handle asset
    $assetId = $request->input('asset_id');
    if (!$assetId && $request->filled(['manual_asset_name', 'manual_brand', 'manual_model'])) {
        // Insert into assets table if manual entry
        $asset = Asset::create([
            'asset_name' => $request->input('manual_asset_name'),
            'brand' => $request->input('manual_brand'),
            'model' => $request->input('manual_model'),
            'location' => $request->input('manual_location'),
            'serial_number' => $request->input('manual_serial_number'),
            'spec' => $request->input('manual_spec'),
        ]);
        $assetId = $asset->id;
    }

    // Handle loan_by
    $loanById = $request->input('loan_by');
    if (!$loanById && $request->filled('manual_loan_by')) {
        // Insert into staff table if manual entry
        $staff = Staff::create([
            'name' => $request->input('manual_loan_by'),
        ]);
        $loanById = $staff->id;
    }

    // Update loan record
    $Disposals->update([
        'asset_id' => $assetId ?? $Disposals->asset_id, // Keep existing asset_id if none provided
        'date_loan' => $request->input('date_loan'),
        'disposal_status_id' => $request->input('disposal_status_id'),
        'status' => 'Disposal',
        'remark' => $request->input('remark'),
    ]);

       return redirect()->route('disposals.edit', $id)->with('status', 'Disposal Asset updated successfully');
   }

   

   // Delete a loan from the database
   public function destroy(int $id)
   {
       $Disposals = History::findOrFail($id);
       $Disposals->delete();

       return redirect()->back()->with('status', 'Disposals Asset Deleted');
   }

   public function import(){
    return view('Disposal.Excelimport');
}

    public function importExcelData(Request $request)
{
    try {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new DisposalImport, $request->file('import_file'));
        return redirect()->back()->with('status', 'Imported Successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Import Failed: ' . $e->getMessage());
    }
}

    public function export(Request $request) 
    {
            // if($request->type == "xslsx"){
            //     $extension = "xlsx";
            //     $exportFormat =  \Maatwebsite\Excel\Excel::XLSX;

            // }elseif($request->type == "csv"){
            //     $extension = "csv";
            //     $exportFormat =  \Maatwebsite\Excel\Excel::CSV;

            // }elseif($request->type == "xls"){
            //     $extension = "xls";
            //     $exportFormat =  \Maatwebsite\Excel\Excel::XLS;

            // }else{
            //     $extension = "xlsx";
            //     $exportFormat =  \Maatwebsite\Excel\Excel::XLSX;
                
            // }
            
            // $filename = 'Disposal Asset List-'.date('d-m-Y').'.'.$extension;
            // return Excel::download(new DisposalExport, $filename,$exportFormat);
        
            Log::info('Export requested with parameters:', $request->all());
        
        try {
            $type = $request->get('type', 'xlsx'); // Default to XLSX
            $filename = 'Disposal Asset List-' . date('d-m-Y') . '.' . $type;
            $exportFormat = match ($type) {
                'xlsx' => \Maatwebsite\Excel\Excel::XLSX,
                'csv' => \Maatwebsite\Excel\Excel::CSV,
                'xls' => \Maatwebsite\Excel\Excel::XLS,
                default => \Maatwebsite\Excel\Excel::XLSX,
            };

                return Excel::download(new DisposalExport, $filename, $exportFormat);
            } catch (\Exception $e) {
                Log::error('Export failed:', ['error' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Export Failed: ' . $e->getMessage());
            }
    }
}
