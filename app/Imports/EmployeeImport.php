<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {

        $dateToday = Carbon::now()->toDateString();
        $department = Department::where('title', '=', $row['DEPARTMENT'])->first();


        return new Employee([
            'employee_id' => $row['EMPLOYEE ID'],
            'first_name' => $row['GIVEN NAME'],
            'last_name' => $row['LAST NAME'],
            'position' => $row['POSITION'],
            'hired_date' => $dateToday,
            'is_active' => true,
            'department_id' => $department ? $department->id : 1
        ]);
    }
}
