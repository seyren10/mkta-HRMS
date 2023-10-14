<?php

namespace App\Imports;

use App\Models\DisciplinaryAction;
use App\Models\Violation;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class DisciplinaryActionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $disciplinaryActionIds = json_decode($row['DISCIPLINARYACTIONID'], true);

        $disciplinaryActions = [];

        foreach ($disciplinaryActionIds as $key => $id) {
            $disciplinaryActions[] = new DisciplinaryAction([
                'violation_id' => $row['VIOLATIONID'],
                'disciplinary_measure_id' => $id,
                'offense_no' => $key + 1

            ]);
        }

        return $disciplinaryActions;
    }
}
