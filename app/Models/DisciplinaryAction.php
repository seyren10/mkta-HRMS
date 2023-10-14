<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaryAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'violation_id',
        'disciplinary_measure_id',
        'offense_no'
    ];

    protected $hidden = [
        'violation_id',
        'disciplinary_measure_id',
    ];

    public function violation()
    {
        return $this->belongsTo(\App\Models\Violation::class, 'violation_id');
    }
    public function disciplinaryMeasure()
    {
        return $this->belongsTo(\App\Models\DisciplinaryMeasure::class, 'disciplinary_measure_id');
    }
}
