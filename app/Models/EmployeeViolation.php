<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeViolation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'violation_id',
    ];

    protected $hidden = [
        'employee_id',
        'violation_id',
    ];

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }
    public function violation()
    {
        return $this->belongsTo(\App\Models\violation::class, 'violation_id');
    }
}
