<?php

namespace App\Imports;

use App\Models\History;
use App\Models\Staff;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class StaffImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Ensure required fields exist in the row
            if (empty($row['nric_no']) || empty($row['name'])) {
                continue; // Skip this row if required fields are missing
            }

            // Check if the staff already exists based on NRIC number
            $staff = Staff::where('nric_no', $row['nric_no'])->first();

            if ($staff) {
                // Update existing staff information
                $staff->update([
                    'name' => $row['name'],
                    'email' => $row['email'] ?? $staff->email,
                    'staff_no' => $row['staff_no'] ?? $staff->staff_no,
                    'department_id' => $row['department_id'] ?? $staff->department_id,
                    'company_id' => $row['company_id'] ?? $staff->company_id,
                    'position' => $row['position'] ?? $staff->position,
                ]);

            } else {
                // Create a new staff record
                $newStaff = Staff::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'staff_no' => $row['staff_no'],
                    'nric_no' => $row['nric_no'],
                    'department_id' => $row['department_id'],
                    'company_id' => $row['company_id'],
                    'position' => $row['position'],
                ]);

            }
        }
    }

}
