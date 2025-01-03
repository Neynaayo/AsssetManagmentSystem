<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompanyImport implements ToCollection, WithHeadingRow
{
    /**
     * Handle the imported collection of rows.
     *
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Find the existing company by name
            $existingCompany = Company::where('name', $row['name'])->first();

            if ($existingCompany) {
                // Check if the existing company's data differs from the imported row
                $dataToUpdate = [];

                if ($row['code'] && $row['code'] !== $existingCompany->code) {
                    $dataToUpdate['code'] = $row['code'];
                }

                // Only update if there is data to change
                if (!empty($dataToUpdate)) {
                    $existingCompany->update($dataToUpdate);
                }
            } else {
                // Create a new company record if it doesn't exist
                Company::create([
                    'name' => $row['name'],
                    'code' => $row['code'] ?? null,
                ]);
            }
        }
    }
}
