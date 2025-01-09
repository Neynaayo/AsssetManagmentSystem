<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = [
        'asset_id',
        'loan_by',
        'date_loan',
        'until_date_loan',
        'disposal_status_id',
        'status',
        'remark',
    ];

    public function asset()
{
    return $this->belongsTo(Asset::class);
}

public function loanedByStaff()
{
    return $this->belongsTo(Staff::class, 'loan_by');
}

public function disposalStatus()
{
    return $this->belongsTo(DisposalStatus::class);
}


}


