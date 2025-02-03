<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['code' => 'ICT', 'name' => 'Information Communication & Technology'],
            ['code' => 'HR', 'name' => 'Human Resource Management'],
            ['code' => 'PSD', 'name' => 'Protective Service'],
            ['code' => 'FAC', 'name' => 'Finance & Account'],
            ['code' => 'C&B', 'name' => 'Compensation & Benefit'],
            ['code' => 'IA', 'name' => 'Internal Audit'],
            ['code' => 'COSEC', 'name' => 'Corporate Services'],
            ['code' => 'MD', 'name' => 'MD Office'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}