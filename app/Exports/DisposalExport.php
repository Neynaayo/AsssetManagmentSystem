<?php

namespace App\Exports;

use App\Models\History;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DisposalExport implements FromView
{
    public function view(): View
    {
        // Filter the data to include only records with status = "Available"
        $disposals = History::where('status', 'Disposal')->get();

        return view('Disposal.export', compact('disposals'));
    }
}
