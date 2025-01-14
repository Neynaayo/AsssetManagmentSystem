<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Staff;
use App\Models\History;
use Illuminate\Http\Request;
use App\Exports\AvailableExport;
use App\Imports\AvailableImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AvailableHistoryController extends Controller
{
    // Display the list of assets with status "Available"

    public function index(Request $request)
    {
        // Get search input and pagination limit
        $search = $request->input('search');
        $perPage = $request->input('per_page', 50);

        
        // Query for loans with related asset and staff details
        $available = History::where('status', 'Available')
            ->when($search, function ($query, $search) {
                $query->where('date_loan', 'like', "%{$search}%")
                    ->orWhere('until_date_loan', 'like', "%{$search}%")
                    ->orWhere('remark', 'like', "%{$search}%")
                    ->orWhereHas('asset', function ($assetQuery) use ($search) {
                        $assetQuery->where('asset_name', 'like', "%{$search}%")
                            ->orWhere('brand', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%")
                            ->orWhere('serial_number', 'like', "%{$search}%")
                            ->orWhere('spec', 'like', "%{$search}%");
                    });
                    // ->orWhereHas('loanedByStaff', function ($staffQuery) use ($search) {
                    //     $staffQuery->where('name', 'like', "%{$search}%")
                    //         ->orWhere('email', 'like', "%{$search}%"); // Add additional staff fields if needed
                    // });
            })
            ->paginate($perPage);

        return view('Available.index', compact('available'));
    }

    // Show the form to create a new asset
    public function create()
    {
        $asset = Asset::whereDoesntHave('histories', function ($query) {
            $query->where('status', 'Disposal');
        })->get();
        $staff = Staff::all();
        return view('Available.create',compact('asset','staff'));
    }

    // Store a new asset with status "Available" in the database
    public function store(Request $request)
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
            'remark' => 'nullable|max:255|string',
        ]);

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
            // Log the asset creation
        Log::info('New asset created: ', ['id' => $assetId]);
        }

        if (!$assetId) {
            return redirect()->back()->withErrors(['asset' => 'Failed to create or find an asset']);
        }

        // Create the new asset
        History::create([
            'asset_id' => $assetId,
            'status' => 'Available',
            'remark' => $request->input('remark'),
        ]);

        return redirect()->route('availables.create')->with('status', 'Available Asset Created');
    }

    // Show the form to edit an existing asset
    public function edit(int $id)
    {
        $available = History::findOrFail($id);
        $asset = Asset::whereDoesntHave('histories', function ($query) {
            $query->where('status', 'Disposal');
        })->get();
        $staff = Staff::all();
        // If the selected asset is linked to this available record
        $selectedAsset = $available->asset_id ? Asset::find($available->asset_id) : null;
        return view('Available.edit', compact('available','staff','asset','selectedAsset'));
    }

    // Update an existing asset in the database
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
            'remark' => 'nullable|max:255|string',
        ]);
        $available = History::findOrFail($id);
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
       
        $available->update([
            'asset_id' => $assetId ?? $available->asset_id, // Keep existing asset_id if none provided
            'status' => 'Available',
            'remark' => $request->input('remark'),
        ]);

        return redirect()->route('availables.edit', $id)->with('status', 'Available Asset updated successfully');
    }

    // Delete an asset from the database
    public function destroy(int $id)
    {
        $available = History::findOrFail($id);
        $available->delete();

        return redirect()->back()->with('status', 'Available Asset Deleted');
    }

    public function import(){
        return view('Available.Excelimport');
    }

        public function importExcelData(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|file|mimes:xlsx,xls',
            ]);

            Excel::import(new AvailableImport, $request->file('import_file'));
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
        
        $filename = 'Available Asset List-'.date('d-m-Y').'.'.$extension;
        return Excel::download(new AvailableExport, $filename,$exportFormat);
    }
}
