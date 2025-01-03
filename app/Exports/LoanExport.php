<?php

namespace App\Exports;

use App\Models\Asset;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\History;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LoanExport implements FromView
//FromCollection, WithHeadings
{
    public function view(): View
    {
        // Filter the data to include only records with status = "Available"
        $loans = History::where('status', 'Loan')->get();

        return view('Loan.export', compact('loans'));
    }
}
