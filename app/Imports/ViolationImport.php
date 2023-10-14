<?php

namespace App\Imports;

use App\Models\Violation;
use App\Models\ViolationType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Str;

HeadingRowFormatter::default('none');
class ViolationImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $violationType = ViolationType::where('violation_type', Str::of($row['TYPE'])->lower())->first();
        return new Violation([
            'description' => $row['DESCRIPTION'],
            'violation_type_id' => $violationType ? $violationType->id : 1,
        ]);;
    }
}
