<?php

namespace App\Exports;

use App\Models\Asset;
use App\Models\company;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyExport implements FromView
//FromCollection, WithHeadings
{
    public function view(): View
    {
        return view('Company.export', [
            'companies' => company::all()
        ]);
    }


}
