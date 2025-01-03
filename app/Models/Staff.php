<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'staff_no',
        'nric_no',
        'department_id',
        'company_id',
        'position',
        
    ];

    /**
     * Relationships
     */

    // Staff belongs to a department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Staff belongs to a company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function currentAssets()
    {
        return $this->hasMany(Asset::class, 'current_owner_id');
    }

    public function previousAssets()
    {
        return $this->hasMany(Asset::class, 'previous_owner_id');
    }

}
