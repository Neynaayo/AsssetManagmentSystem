<?php

namespace App\Exports;

use App\Models\Department;
use App\Models\History;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DepartmentExport
implements FromView
{
    public function view(): View
    {
        return view('Department.export', [
            'departments' => Department::all()
        ]);
    }
}
