<?php

namespace App\Exports;

use App\Models\History;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AvailableExport implements FromView
{
    public function view(): View
    {
        // Filter the data to include only records with status = "Available"
        $availables = History::where('status', 'Available')->get();

        return view('Available.export', compact('availables'));
    }
}
