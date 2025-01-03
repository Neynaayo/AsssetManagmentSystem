<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable =[
            'asset_name',
           'serial_number',
           'asset_no',
            'brand',
            'model',
            'type',
            'spec',
            'domain',
            'location',
            'company_id',
            'department_id',
            'user_id',
            'previous_user_id',
            'paid_by',
            'conditions',
            'remark',

    ];

    // Define relationship with Company - join table
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Define relationship with Department - join table
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

        public function histories()
    {
        return $this->hasMany(History::class);
    }
    
    public function currentOwner()
    {
        return $this->belongsTo(Staff::class, 'user_id');
    }

    public function previousOwner()
    {
        return $this->belongsTo(Staff::class, 'previous_user_id');
    }

}
