<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\History;
use App\Models\Staff;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class DepartmentImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Find the existing company by name
            $existingDepartment = Department::where('name', $row['name'])->first();

            if ($existingDepartment) {
                // Check if the existing company's data differs from the imported row
                $dataToUpdate = [];

                if ($row['code'] && $row['code'] !== $existingDepartment->code) {
                    $dataToUpdate['code'] = $row['code'];
                }

                // Only update if there is data to change
                if (!empty($dataToUpdate)) {
                    $existingDepartment->update($dataToUpdate);
                }
            } else {
                // Create a new company record if it doesn't exist
                Department::create([
                    'name' => $row['name'],
                    'code' => $row['code'] ?? null,
                ]);
            }
        }
    }

}
