<?php

namespace App\Imports;

use App\Models\History;
use App\Models\Staff;
use App\Models\Department;
use App\Models\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

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

            // // Resolve department_id from department code
            // $department = Department::where('code', $row['department'])->first();
            // $departmentId = $department ? $department->id : null;

            // // Resolve company_id from company code
            // $company = Company::where('code', $row['company'])->first();
            // $companyId = $company ? $company->id : null;

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

            // Check if the staff already exists based on NRIC number
            $staff = Staff::where('nric_no', $row['nric_no'])
                ->orWhere('staff_no', $row['staff_no'])
                ->orWhere('email', $row['email'])
                ->first();

            if ($staff) {
                // Update existing staff information
                $staff->update([
                    'name' => $row['name'] ?? $staff->name,
                    'email' => $row['email'] ?? $staff->email,
                    'staff_no' => $row['staff_no'] ?? $staff->staff_no,
                    'nric_no' => $row['nric_no'] ?? $staff->nric_no,
                    'department_id' => $department->id ?? null,
                    'company_id' => $company->id ?? null,
                    'position' => $row['position'] ?? $staff->position,
                ]);
            } else {
                // Create a new staff record
                Staff::create([
                    'name' => $row['name'] ?? null,
                    'email' => $row['email'] ?? null,
                    'staff_no' => $row['staff_no'] ?? null,
                    'nric_no' => $row['nric_no'] ?? null,
                    'department_id' => $department->id ?? null,
                    'company_id' => $company->id ?? null,
                    'position' => $row['position'] ?? null,
                ]);
            }
        }
    }
}
