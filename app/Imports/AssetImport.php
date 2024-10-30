<?php

namespace App\Imports;

use App\Models\Asset;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $assets = Asset::where('serial_number',$row['serial_number'])->first();
            if($assets){

                $assets->update([
                    'asset_name' => $row['asset_name'],
                    'asset_no' => $row['asset_number'],
                    'location' => $row['location'],
                    'brand' => $row['brand'],
                ]);
            }else{
            Asset::create([
                'asset_name' => $row['asset_name'],
                'serial_number' => $row['serial_number'],
                'asset_no' => $row['asset_number'],
                'location' => $row['location'],
                'brand' => $row['brand'],
                
            ]);
            }
        }
    }
}

