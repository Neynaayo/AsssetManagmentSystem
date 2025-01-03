<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';

    protected $fillable =[
        'code',
        'name',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function User()
    {
        return $this->hasMany(User::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
