<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeNte extends Model
{
    use HasFactory;

    protected $fillable = [
        'offense_type',
        'offense_length'
    ];


    public function offenses()
    {
        return $this->hasMany(\App\Models\Offense::class);
    }
}
