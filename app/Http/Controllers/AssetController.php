<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Staff;
use App\Models\company;
use App\Models\Department;
use App\Exports\AssetExport;
use App\Imports\AssetImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Contracts\Service\Attribute\Required;


class AssetController extends Controller
{
    public function index(Request $request)
    {
        // Get request inputs
        $search = $request->input('search');
        $departmentId = $request->input('department_id');
        $perPage = $request->input('per_page', 10);
    
        // Get all departments for the dropdown
        $departments = Department::all();
    
        // Query assets with relationships
        $assetsQuery = Asset::with(['department', 'currentOwner', 'previousOwner', 'company']);
    
        // Apply filters
        if (Auth::user()->roleid == 1) {
            // Super Admin: view all assets
            $assetsQuery->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('asset_name', 'like', "%{$search}%")
                          ->orWhere('serial_number', 'like', "%{$search}%")
                          ->orWhere('asset_no', 'like', "%{$search}%")
                          ->orWhere('location', 'like', "%{$search}%")
                          ->orWhere('brand', 'like', "%{$search}%")
                          ->orWhere('model', 'like', "%{$search}%")
                          ->orWhere('type', 'like', "%{$search}%")
                          ->orWhere('spec', 'like', "%{$search}%")
                          ->orWhere('domain', 'like', "%{$search}%")
                          ->orWhere('remark', 'like', "%{$search}%");
                });
            });
        } else {
            // Admin: view only assets from their department
            $assetsQuery->where('department_id', Auth::user()->department_id)
                        ->when($search, function ($query, $search) {
                            $query->where(function ($query) use ($search) {
                                $query->where('asset_name', 'like', "%{$search}%")
                                      ->orWhere('serial_number', 'like', "%{$search}%")
                                      ->orWhere('asset_no', 'like', "%{$search}%")
                                      ->orWhere('location', 'like', "%{$search}%")
                                      ->orWhere('brand', 'like', "%{$search}%")
                                      ->orWhere('model', 'like', "%{$search}%")
                                      ->orWhere('type', 'like', "%{$search}%")
                                      ->orWhere('spec', 'like', "%{$search}%")
                                      ->orWhere('domain', 'like', "%{$search}%")
                                      ->orWhere('remark', 'like', "%{$search}%");
                            });
                        });
        }
    
        // Apply department filter if selected
        $assetsQuery->when($departmentId, function ($query, $departmentId) {
            $query->where('department_id', $departmentId);
        });
    
        // Paginate results
        $assets = $assetsQuery->paginate($perPage);
    
        // Pass variables to the view
        return view('Asset.index', compact('assets', 'search', 'departments', 'departmentId', 'perPage'));
    }
    


        public function create()
        {
            $departments = Department::all();
            $companies = Company::all();
            $staff = Staff::all();
            return view('Asset.create', compact('departments', 'companies', 'staff'));
        }
    
        public function store(Request $request)
        {
            $request->validate([
                'asset_name' => 'nullable|max:255|string',
                'serial_number' => 'required|max:255|string',
                'asset_no' => 'nullable|max:255|string',
                'location' => 'nullable|max:255|string',
                'brand' => 'nullable|max:255|string',
                'model' => 'nullable|max:255|string',
                'type' => 'nullable|max:255|string',
                'spec' => 'nullable|max:255|string',
                'domain' => 'nullable|max:255|string',
                'company_id' => 'required|integer|exists:company,id',
                'department_id' => 'required|integer|exists:department,id',
                'current_owner_name' => 'required|string|max:255',
                'prev_owner_name' => 'nullable|string|max:255',
                'paid_by' => 'nullable|max:255|string',
                'conditions' => 'nullable|max:255|string',
                'remark' => 'nullable|max:255|string',
            ]);

            // Find or create the current owner
            $currentOwner = Staff::firstOrCreate(
                ['name' => $request->current_owner_name],
                ['department_id' => $request->department_id]
            );

            // Find or create the previous owner (if provided)
            $previousOwner = null;
            if (!empty($request->prev_owner_name)) {
                $previousOwner = Staff::firstOrCreate(
                    ['name' => $request->prev_owner_name],
                    ['department_id' => $request->department_id]
                );
            }

            // Create the Asset
            Asset::create([
                'asset_name' => $request->asset_name,
                'serial_number' => $request->serial_number,
                'asset_no' => $request->asset_no,
                'location' => $request->location,
                'brand' => $request->brand,
                'model' => $request->model,
                'type' => $request->type,
                'spec' => $request->spec,
                'domain' => $request->domain,
                'company_id' => $request->company_id,
                'department_id' => $request->department_id,
                'user_id' => $currentOwner->id, // Current owner ID
                'previous_user_id' => $previousOwner?->id, // Previous owner ID (if exists)
                'paid_by' => $request->paid_by,
                'conditions' => $request->conditions,
                'remark' => $request->remark,
            ]);

            return redirect()->route('assets.index')->with('status', 'Asset Created Successfully');
        }

    
        public function edit(int $id)
        {
            $assets = Asset::with(['currentOwner', 'previousOwner'])->findOrFail($id);
            $department = Department::all();
            $company = Company::all();
            $staff = Staff::all();
            return view('Asset.edit', compact('assets', 'department', 'company', 'staff'));
        }

    
        public function update(Request $request, int $id)
        {
            $request->validate([
                'asset_name' => 'nullable|max:255|string',
                'serial_number' => 'required|max:255|string',
                'asset_no' => 'nullable|max:255|string',
                'location' => 'nullable|max:255|string',
                'brand' => 'nullable|max:255|string',
                'model' => 'nullable|max:255|string',
                'type' => 'nullable|max:255|string',
                'spec' => 'nullable|max:255|string',
                'domain' => 'nullable|max:255|string',
                'company_id' => 'required|integer|exists:company,id',
                'department_id' => 'required|integer|exists:department,id',
                'current_owner_name' => 'required|string|max:255',
                'prev_owner_name' => 'nullable|string|max:255',
                'paid_by' => 'nullable|max:255|string',
                'conditions' => 'nullable|max:255|string',
                'remark' => 'nullable|max:255|string',
            ]);

            $asset = Asset::findOrFail($id);

            // Handle Current Owner
            $currentOwner = Staff::firstOrCreate(
                ['name' => $request->input('current_owner_name')], // Match condition
                ['email' => $request->input('current_owner_email', '')] // Additional fields if new
            );

            // Handle Previous Owner (if provided)
            $previousOwner = null;
            if ($request->filled('prev_owner_name')) {
                $previousOwner = Staff::firstOrCreate(
                    ['name' => $request->input('prev_owner_name')], // Match condition
                    ['email' => $request->input('prev_owner_email', '')] // Additional fields if new
                );
            }

            // Update asset details
            $asset->update([
                'asset_name' => $request->input('asset_name'),
                'serial_number' => $request->input('serial_number'),
                'asset_no' => $request->input('asset_no'),
                'location' => $request->input('location'),
                'brand' => $request->input('brand'),
                'model' => $request->input('model'),
                'type' => $request->input('type'),
                'spec' => $request->input('spec'),
                'domain' => $request->input('domain'),
                'company_id' => $request->input('company_id'),
                'department_id' => $request->input('department_id'),
                'user_id' => $currentOwner->id, // Set current owner ID
                'previous_user_id' => $previousOwner?->id, // Set previous owner ID (if exists)
                'paid_by' => $request->input('paid_by'),
                'conditions' => $request->input('conditions'),
                'remark' => $request->input('remark'),
            ]);

            return redirect()->route('assets.index')->with('status', 'Asset updated successfully.');
        }


    
        public function destroy(int $id)
        {
            $asset = Asset::findOrFail($id);
            $asset->delete();
            return redirect()->back()->with('status', 'Asset Deleted Successfully');
        }

    public function import(){
        return view('Asset.Excelimport');
    }

        public function importExcelData(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|file|mimes:xlsx,xls',
            ]);

            Excel::import(new AssetImport, $request->file('import_file'));
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
        
        $filename = 'Asset List-'.date('d-m-Y').'.'.$extension;
        return Excel::download(new AssetExport, $filename,$exportFormat);
    }

    //search function maybe
        public function show($id)
    {
        $asset = Asset::findOrFail($id);
        return view('Asset.details', compact('asset'));
    }


    public function generateQrCode($id)
    {
        // Fetch the asset data
        $asset = Asset::findOrFail($id);
        
        // Generate the QR code binary data
        $qrCodeData = QrCode::format('png')
            ->merge(public_path('images/puncak-niaga-holdings-logo.jpg'), 0.3, true)
            ->size(300)
            ->errorCorrection('H')
            ->backgroundColor(255, 255, 255)
            ->color(0, 51, 153) // Navy blue QR code
            ->generate(route('assets.details', $id));
        
        // Create an image from the QR code binary data
        $qrImage = Image::make($qrCodeData);
        
        // Create a square canvas
        $canvas = Image::canvas(400, 400, '#ffffff');
        
        // Draw a square box for the QR code
        $canvas->rectangle(50, 50, 350, 350, function($draw) {
            $draw->background(null);
            $draw->border(2, '#000000');
        });
        
        // Add the asset name at the top
        $canvas->text('Asset Name: ' . $asset->asset_name, 200, 30, function ($font) {
            $font->file(public_path('fonts/ARIAL.ttf'));
            $font->size(20);
            $font->align('center');
            $font->valign('top');
            $font->color('#000000');
        });
        
        // Insert the QR code into the canvas, centered in the box
        $canvas->insert($qrImage, 'center', 0, 0);
        
        // Add the serial number at the bottom
        $canvas->text('Serial Number: ' . $asset->serial_number, 200, 370, function ($font) {
            $font->file(public_path('fonts/ARIAL.ttf'));
            $font->size(20);
            $font->align('center');
            $font->valign('bottom');
            $font->color('#000000');
        });
    
        // Set headers for auto-download
        $filename = str_replace(' ', '-', $asset->asset_name) . '-' . $asset->serial_number . '-qr.png';
        $headers = [
        'Content-Type' => 'image/png',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        ];

        // Return with force download headers
        return response($canvas->encode('png'), 200, $headers);
        }

        //for After Scanning QR
        public function details($id)
        {
            $asset = Asset::findOrFail($id);
            return view('Asset.details', [
                'asset' => $asset,
                'noSidebar' => true  // This flag will be used to choose the layout
            ]);
        }

        public function showQrCode($id)
        {
            // Fetch the asset data
            $asset = Asset::findOrFail($id);

            // Generate the QR code binary data
            $qrCodeData = QrCode::format('png')
                ->merge(public_path('images/puncak-niaga-holdings-logo.jpg'), 0.3, true)
                ->size(300)
                ->errorCorrection('H')
                ->generate(route('assets.details', $id));

            // Create an image from the QR code binary data
            $qrImage = Image::make($qrCodeData);

            // Create a square canvas
            $canvas = Image::canvas(400, 400, '#ffffff');

            // Draw a square box for the QR code
            $canvas->rectangle(50, 50, 350, 350, function($draw) {
                $draw->background(null);
                $draw->border(2, '#000000');
            });

            // Add the asset name at the top
            $canvas->text('Asset Name: ' . $asset->asset_name, 200, 30, function ($font) {
                $font->file(public_path('fonts/ARIAL.ttf'));
                $font->size(20);
                $font->align('center');
                $font->valign('top');
                $font->color('#000000');
            });

            // Insert the QR code into the canvas, centered in the box
            $canvas->insert($qrImage, 'center', 0, 0);

            // Add the serial number at the bottom
            $canvas->text('Serial Number: ' . $asset->serial_number, 200, 370, function ($font) {
                $font->file(public_path('fonts/ARIAL.ttf'));
                $font->size(20);
                $font->align('center');
                $font->valign('bottom');
                $font->color('#000000');
            });

            // Return the generated QR code image to the view
            $encodedImage = $canvas->encode('data-url');
            return view('Asset.qrCode', compact('asset', 'encodedImage'));
        }



       
}

