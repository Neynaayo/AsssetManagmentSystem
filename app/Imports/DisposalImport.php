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
            // Format dates
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

            // Find or create disposal status
            $disposalStatus = null;
            if (isset($row['disposal_status'])) {
                $disposalStatus = DisposalStatus::firstOrCreate(
                    ['name' => $row['disposal_status']]
                );
            }

            // Find existing loan history or create a new one
            $loan = History::where('asset_id', $asset->id)
                           ->where('status', 'Disposal')
                           ->first();

            if ($loan) {
                // Update existing loan history
                $loan->update([
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

            // Parse date in d/m/Y format
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Return null if the date is invalid
        }
    }
}
