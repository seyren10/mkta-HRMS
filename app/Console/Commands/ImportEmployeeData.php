<?php

namespace App\Console\Commands;

use App\Imports\EmployeeImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportEmployeeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from Excel file to employee table (make sure to populate the departments table first) ';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Excel::import(new EmployeeImport, public_path('ImportsExcel/employee.xlsx'));
    }
}
