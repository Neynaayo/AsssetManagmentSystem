<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            ['code' => 'PNMS', 'name' => 'Puncak Niaga Management Services Sdn Bhd'],
            ['code' => 'PNCSB', 'name' => 'Puncak Niaga Construction Sdn Bhd'],
            ['code' => 'Danum', 'name' => 'Danum Sinar Sdn Bhd'],
            ['code' => 'TRI', 'name' => 'TRIplc Berhad'],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}