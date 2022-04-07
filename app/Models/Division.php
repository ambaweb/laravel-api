<?php

namespace App\Models;

use App\Models\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'builder_id',
        'name',
        'state',
        'latitude',
        'longitude',
        'is_active'
    ];

    public function builder()
    {
        return $this->belongsTo(Builder::class);
    }

    public function setStateAttribute($value){
        $this->attributes['state'] = strtoupper($value);
    }
}
