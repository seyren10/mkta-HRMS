<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaryMeasure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function disciplinaryActions()
    {
        return  $this->hasMany(\App\Models\DisciplinaryAction::class);
    }
}
