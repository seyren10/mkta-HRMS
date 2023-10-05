<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'violation_type',
    ];


    public function violations()
    {
        return $this->hasMany(\App\Models\Violation::class)->orderBy('id', 'desc');
    }
}
