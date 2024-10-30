<?php

namespace App\Http\Controllers;

use App\Exports\AssetExport;
use App\Models\Asset;
use App\Imports\AssetImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Contracts\Service\Attribute\Required;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AssetController extends Controller
{
    public function index(Request $request){

        // $assets = Asset::get();
        // return view('Asset.index',compact('assets'));

        // Get the search term from the request
    $search = $request->input('search');

    // Query to get assets based on search term
    $assets = Asset::query()
        ->when($search, function ($query, $search) {
            $query->where('asset_name', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('asset_no', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
        })
        ->paginate(10);

    // Pass the assets and search term to the view
    return view('Asset.index', compact('assets', 'search'));
    }

    public function create(){
        return view('Asset.create');
    }

    public function store(Request $request){
        $request->validate([
        'asset_name' => 'required|max:255|string',
        'serial_number'  => 'required|max:255|string',
        'asset_no' => 'required|max:255|string',
        'location' => 'required|max:255|string',
        'brand'  => 'required|max:255|string',
        
        ]);

        Asset::create([
        'asset_name' => $request->asset_name,
        'serial_number'  => $request->serial_number,
        'asset_no' => $request->asset_no,
        'location' => $request->location,
        'brand'  => $request->brand,
        ]);

        return redirect('Asset/create')->with('status','Asset Created');
    }

    public function edit(int $id){

        $assets = Asset::findOrFail($id);
            // return $assets;
        return view('Asset.edit',compact('assets'));
    }

    public function update(Request $request, int $id){
        $request->validate([
            'asset_name' => 'required|max:255|string',
            'serial_number'  => 'required|max:255|string',
            'asset_no' => 'required|max:255|string',
            'location' => 'required|max:255|string',
            'brand'  => 'required|max:255|string',
            ]);
    
            Asset::findOrFail($id)->update([
            'asset_name' => $request->asset_name,
            'serial_number'  => $request->serial_number,
            'asset_no' => $request->asset_no,
            'location' => $request->location,
            'brand'  => $request->brand,
            ]);
    
            return redirect()->back()->with('status','Asset Update');
    }

    public function destroy(int $id){

        $assets=Asset::findOrFail($id);
        $assets->delete();

        return redirect()->back()->with('status','Asset Deleted');
    }

    public function import(){
        return view('Asset.Excelimport');
    }

    public function importExcelData(Request $request){
        $request->validate([
            'import_file' =>[
                'required',
                'file'
            ],
        ]);
        Excel::import(new AssetImport, $request->file('import_file'));
        return redirect()-> back()-> with('status','Imported Syccessfully');
   
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

        public function showQrCode($id)
    {
        // $asset = Asset::findOrFail($id);
        // $qrCode = QrCode::size(200)->generate(url("Asset/{$id}/details"));
        // return view('Asset.show_qr_code', compact('asset', 'qrCode'));
        
            $asset = Asset::findOrFail($id);

            // Generate the QR code in SVG format
            $qrCode = QrCode::format('svg')->size(200)->generate(url("Asset/{$id}/details"));

            return view('Asset.show_qr_code', compact('asset', 'qrCode'));
    }

        public function show($id)
    {
        $asset = Asset::findOrFail($id);
        return view('Asset.details', compact('asset'));
    }

            public function dashboard()
        {
            $assetCount = Asset::count(); // Gets the total count of assets
            return view('dashboard', compact('assetCount')); // Passes count to the view
        }

}

