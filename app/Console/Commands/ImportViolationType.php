<?php

namespace App\Console\Commands;

use App\Imports\ViolationTypeImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportViolationType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:violation-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from Excel file to violation_types table';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        Excel::import(new ViolationTypeImport, public_path('importsExcel/violation_types.xlsx'));
    }
}
