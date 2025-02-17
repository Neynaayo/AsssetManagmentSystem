<?php

namespace App\Imports;

use App\Models\History;
use App\Models\Asset;
use App\Models\Staff;
use App\Models\DisposalStatus;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class DisposalImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Format dates - Assume Dates Loan as a Date Disposal (goes into the same column)
            $dateLoan = isset($row['date_disposals']) ? $this->formatDate($row['date_disposals']) : null;

            // Find or create asset by serial number
            $asset = Asset::firstOrCreate(
                ['serial_number' => $row['serial_number']],
                [
                    'asset_name' => $row['asset_name'],
                    'brand' => $row['brand'],
                    'model' => $row['model'],
                    'location' => $row['location'],
                    'spec' => $row['spec'],
                ]
            );

            // Find the disposal status by name first before creating
            if (isset($row['disposal_status'])) {
                $disposalStatus = DisposalStatus::where('name', trim($row['disposal_status']))->first();
                
                if (!$disposalStatus) {
                    $disposalStatus = DisposalStatus::create(['name' => trim($row['disposal_status'])]);
                }
            }


            // Find existing loan history or create a new one
            $disposal = History::where('asset_id', $asset->id)
                           ->where('status', 'Disposal')
                           ->first();

            if ($disposal) {
                // Update existing loan history
                $disposal->update([
                    'date_loan' => $dateLoan,
                    'remark' => $row['remark'],
                    'disposal_status_id' => $disposalStatus ? $disposalStatus->id : null,
                ]);
            } else {
                // Create a new loan history
                History::create([
                    'asset_id' => $asset->id,
                    'date_loan' => $dateLoan,
                    'status' => 'Disposal',
                    'disposal_status_id' => $disposalStatus ? $disposalStatus->id : null,
                    'remark' => $row['remark'],
                ]);
            }
        }
    }

    /**
     * Format date to Y-m-d.
     */
    private function formatDate($date)
        {
            try {
                if (is_numeric($date)) {
                    // Handle Excel serialized date format
                    return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date))->format('Y-m-d');
                }

                // Define possible date formats
                $formats = ['d/m/Y', 'd-m-Y', 'Y/m/d', 'Y-m-d', 'm/d/Y', 'm-d-Y'];

                // Try parsing the date with different formats
                foreach ($formats as $format) {
                    try {
                        return Carbon::createFromFormat($format, $date)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Ignore and try the next format
                        continue;
                    }
                }
            } catch (\Exception $e) {
                return null; // Return null if the date is invalid
            }

            return null; // If no format matches, return null
        }

}
