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
        'zip'
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
