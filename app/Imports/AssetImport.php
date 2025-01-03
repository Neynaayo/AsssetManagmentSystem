<?php


namespace App\Imports;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        static $companyCache = [];
        static $departmentCache = [];
        static $staffCache = [];

        foreach ($rows as $row) {
            try {
                // Normalize row keys
                $row = collect($row)->mapWithKeys(function ($value, $key) {
                    return [strtolower(trim(str_replace(' ', '_', $key))) => $value];
                });

                // Skip rows without serial number
                if (empty($row['serial_number'])) {
                    Log::warning("Skipped row with missing serial number: " . json_encode($row));
                    continue;
                }

                // Cache or create company
                $companyName = $row['company'] ?? null;
                if ($companyName) {
                    $company = $companyCache[$companyName] ??= Company::firstOrCreate(['name' => $companyName]);
                }

                // Cache or create department
                $departmentName = $row['department'] ?? null;
                if ($departmentName) {
                    $department = $departmentCache[$departmentName] ??= Department::firstOrCreate(['name' => $departmentName]);
                }

                // Cache or create current user
                $currentUserName = $row['user'] ?? null;
                if ($currentUserName) {
                    $currentUser = $staffCache[$currentUserName] ??= Staff::firstOrCreate(['name' => $currentUserName]);
                }

                // Cache or create previous user
                $previousUserName = $row['previous_owner'] ?? null;
                if ($previousUserName) {
                    $previousUser = $staffCache[$previousUserName] ??= Staff::firstOrCreate(['name' => $previousUserName]);
                }

                // Generate asset name from brand and model
                $assetName = trim(sprintf('%s %s', $row['brand'] ?? '', $row['model'] ?? ''));

                // Check if asset exists
                $existingAsset = Asset::where('serial_number', $row['serial_number'])->first();

                $assetData = [
                    'asset_name' => $assetName,
                    'serial_number' => $row['serial_number'],
                    'asset_no' => $row['no'] ?? '',
                    'brand' => $row['brand'] ?? '',
                    'model' => $row['model'] ?? '',
                    'type' => $row['type'] ?? '',
                    'spec' => $row['spec'] ?? '',
                    'domain' => $row['domain'] ?? '',
                    'location' => $row['location'] ?? '',
                    'company_id' => $company->id ?? null,
                    'department_id' => $department->id ?? null,
                    'user_id' => $currentUser->id ?? null,
                    'previous_user_id' => $previousUser->id ?? null,
                    'paid_by' => $row['paid_by'] ?? '',
                    'conditions' => $row['condition'] ?? '',
                    'remark' => $row['remark'] ?? '',
                ];

                if ($existingAsset) {
                    // Check for differences and update if necessary
                    $changes = array_diff_assoc($assetData, $existingAsset->toArray());
                    if (!empty($changes)) {
                        $existingAsset->update($assetData);
                        Log::info("Updated asset: {$row['serial_number']}");
                    } else {
                        Log::info("No changes for asset: {$row['serial_number']}");
                    }
                } else {
                    // Create new asset
                    Asset::create($assetData);
                    Log::info("Created new asset: {$row['serial_number']}");
                }
            } catch (\Exception $e) {
                Log::error("Error processing row: " . json_encode($row) . " - " . $e->getMessage());
            }
        }
    }
}


// namespace App\Imports;

// use App\Models\Asset;
// use App\Models\Company;
// use App\Models\Department;
// use App\Models\Staff;
// use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\Log;
// use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class AssetImport implements ToCollection, WithHeadingRow
// {
//     public function collection(Collection $rows)
//     {
//         static $companyCache = [];
//         static $departmentCache = [];

//         foreach ($rows as $row) {
//             // Normalize headers
//             $row = collect($row)->mapWithKeys(function ($value, $key) {
//                 return [strtolower(trim(str_replace(' ', '_', $key))) => $value];
//             });

//             // Skip rows with missing required fields
//             if (empty($row['serial_number'])) {
//                 Log::warning("Skipped row with missing serial number: " . json_encode($row));
//                 continue;
//             }

//             // Cache and retrieve related entities
//             $company = $companyCache[$row['company']] ??= Company::firstOrCreate(['name' => $row['company']]);
//             $department = $departmentCache[$row['department']] ??= Department::firstOrCreate(['name' => $row['department']]);
//             $currentUser = Staff::firstOrCreate(['name' => $row['user']]);
//             $previousUser = Staff::firstOrCreate(['name' => $row['previous_owner']]);

//             // Prepare asset data
//             $assetData = [
//                 'asset_name' => trim(sprintf('%s %s', $row['brand'] ?? '', $row['model'] ?? '')),
//                 'serial_number' => $row['serial_number'],
//                 'asset_no' => $row['no'] ?? '',
//                 'brand' => $row['brand'] ?? '',
//                 'model' => $row['model'] ?? '',
//                 'type' => $row['type'] ?? '',
//                 'spec' => $row['spec'] ?? '',
//                 'domain' => $row['domain'] ?? '',
//                 'location' => $row['location'] ?? '',
//                 'company_id' => $company->id,
//                 'department_id' => $department->id,
//                 'user_id' => $currentUser->id,
//                 'previous_user_id' => $previousUser->id,
//                 'paid_by' => $row['paid_by'] ?? '',
//                 'conditions' => $row['condition'] ?? '',
//                 'remark' => $row['remark'] ?? '',
//             ];

//             try {
//                 $asset = Asset::where('serial_number', $assetData['serial_number'])->first();
//                 $this->saveAsset($assetData, $asset);
//             } catch (\Exception $e) {
//                 Log::error("Error processing asset: " . json_encode($row) . " - " . $e->getMessage());
//             }
//         }
//     }

//     protected function saveAsset(array $data, Asset $asset = null)
//     {
//         if ($asset) {
//             $asset->update($data);
//         } else {
//             Asset::create($data);
//         }
//     }
// }
