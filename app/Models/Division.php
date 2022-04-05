<?php

namespace App\Models;

use App\Models\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state',
        'latitude',
        'longitude'
    ];

    public function builder()
    {
        return $this->belongsTo(Builder::class);
    }
}
