<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeNTE extends Model
{
    use HasFactory;

    protected $fillable = [
        'offense_type',
        'offense_length'
    ];


    public function offense()
    {
        return $this->hasOne(\App\Models\Offense::class);
    }
}
