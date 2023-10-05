<?php

namespace App\Console\Commands;

use App\Imports\ViolationImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportViolationData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:violation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from Excel file to violations table (make sure to populate the violation_types table first) ';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        Excel::import(new ViolationImport, public_path('importsExcel/violations.xlsx'));
    }
}
