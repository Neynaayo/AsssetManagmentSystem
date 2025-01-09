<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DisposalStatus;

class DisposalStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Pending', 'In Progress', 'Confirm Disposal'];

    foreach ($statuses as $status) {
        DisposalStatus::updateOrCreate(['name' => $status]);
    }
    }
}
