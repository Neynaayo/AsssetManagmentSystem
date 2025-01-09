<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisposalStatus extends Model
{
    protected $fillable = ['name'];

    public function history()
    {
        return $this->hasMany(History::class, 'disposal_status_id');
    }
}

