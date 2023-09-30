<?php

namespace App\Console\Commands;

use App\Imports\EmployeeNteImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportEmployeeNteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:employee-nte';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from Excel file to employee-ntes table';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        Excel::import(new EmployeeNteImport, public_path('importsExcel/nte_types.xlsx'));
    }
}
