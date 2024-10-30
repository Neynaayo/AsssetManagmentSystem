<?php

namespace App\Exports;

use App\Models\Asset;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AssetExport implements FromView
//FromCollection, WithHeadings
{
    public function view(): View
    {
        return view('Asset.export', [
            'assets' => Asset::all()
        ]);
    }

    // /** NOT USING BLADE VIEW
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Asset::select('asset_name',
    //         'serial_number',
    //         'asset_no',
    //         'location',
    //         'brand')->get();
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Asset Name',
    //         'Serial Number',
    //         'Asset Number',
    //         'Location',
    //         'Brand',

    //     ];
    // }
}
