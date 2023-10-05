<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'action_length',
        'violation_type_id'
    ];

    protected $hidden = [
        'violation_type_id'
    ];

    public function violationType()
    {
        return $this->belongsTo(\App\Models\ViolationType::class, 'violation_type_id');
    }
}
