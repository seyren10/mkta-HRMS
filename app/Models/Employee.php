<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'position',
        'hired_date',
        'is_active',
        'department_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
    protected $hidden = [
        'department_id'
    ];

    public function ownedByDepartment()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }

    public function employeeContracts()
    {
        return $this->hasMany(\App\Models\EmployeeContract::class);
    }
}
