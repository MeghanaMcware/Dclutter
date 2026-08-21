<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'corporation_id',
        'constituency_id',
        'address',
        'status',
    ];

    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    public function constituency()
    {
        return $this->belongsTo(Constituency::class);
    }
}
