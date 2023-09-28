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
    protected $signature = 'employee:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from Excel file to employee table ';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Excel::import(new EmployeeImport, public_path('employee_masterlist.xlsx'));
    }
}
