<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date'
    ];

    public function ownedByEmployee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }
}
