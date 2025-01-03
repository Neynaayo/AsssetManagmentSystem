<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    protected $table = 'company';

    protected $fillable =[
        'code',
        'name',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    
}
