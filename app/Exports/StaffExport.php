<?php

namespace App\Exports;

use App\Models\Asset;
use App\Models\Staff;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StaffExport implements FromView
//FromCollection, WithHeadings
{
    public function view(): View
    {
        return view('Staff.export', [
            'staff' => Staff::all()
        ]);
    }
}
