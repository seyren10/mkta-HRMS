<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'offense_level'
    ];

    public function employeeNte()
    {
        return $this->belongsTo(\App\Models\EmployeeNTE::class);
    }
}
