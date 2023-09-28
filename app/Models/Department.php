<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'division',
        'description'
    ];

    public function employees()
    {
        return $this->hasMany(\App\Models\Employee::class);
    }
}
