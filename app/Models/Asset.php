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
        'location',
        'brand',

    ];
}
