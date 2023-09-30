<?php

namespace App\Console\Commands;

use App\Imports\DepartmentImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportDepartmentData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:department';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import department data from Excel file to departments table ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Excel::import(new DepartmentImport, public_path('ImportsExcel/department.xlsx'));
    }
}
