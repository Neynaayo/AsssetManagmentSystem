<?php

namespace App\Imports;

use App\Models\History;
use App\Models\Asset;
use App\Models\Staff;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class LoanImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Format dates
            $dateLoan = isset($row['date_loan']) ? $this->formatDate($row['date_loan']) : null;
            $untilDateLoan = isset($row['date_loan_until']) ? $this->formatDate($row['date_loan_until']) : null;

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

            // Find or create staff by name
            $staff = null;
            if (!empty($row['loan_by'])) {
                $staff = Staff::firstOrCreate(
                    ['name' => $row['loan_by']],
                    // ['department_id' => null] // Add additional staff fields if necessary
                );
            }

            // Find existing loan history or create a new one
            $loan = History::where('asset_id', $asset->id)->where('status', 'LOAN')->first();

            if ($loan) {
                // Update existing loan history
                $loan->update([
                    'loan_by' => $staff ? $staff->id : null,
                    'date_loan' => $dateLoan,
                    'until_date_loan' => $untilDateLoan,
                    'remark' => $row['remark'],
                ]);
            } else {
                // Create a new loan history
                History::create([
                    'asset_id' => $asset->id,
                    'loan_by' => $staff ? $staff->id : null,
                    'date_loan' => $dateLoan,
                    'until_date_loan' => $untilDateLoan,
                    'remark' => $row['remark'],
                    'status' => 'LOAN',
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
