<?php

namespace App\Models;

use App\Http\Resources\EmployeeResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Employee extends Model
{
    use HasFactory;
    use Searchable;

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

    public function employeeViolations()
    {
        return $this->hasMany(\App\Models\EmployeeViolation::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'employee_id' => $this->employee_id,
            'position' => $this->position
        ];
    }
}
