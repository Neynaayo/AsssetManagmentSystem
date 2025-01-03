<?php

namespace App\Exports;

use App\Models\Asset;
use App\Models\User;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
//FromCollection, WithHeadings
{
    public function view(): View
    {
        return view('User.export', [
            'user' => User::all()
        ]);
    }

}
