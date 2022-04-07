<?php

namespace App\Models;

use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Builder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'address2',
        'city',
        'state',
        'postal_code',
        'is_active'
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function setStateAttribute($value){
        $this->attributes['state'] = strtoupper($value);
    }
}
