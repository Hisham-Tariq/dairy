<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id',
        'temperature',
        'time',
        'production_type',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
