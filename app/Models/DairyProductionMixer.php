<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DairyProductionMixer extends Model
{
    use HasFactory;

    protected $fillable = [
        'dairy_production_id',
        'worker_id',
    ];

    public function dairyProduction()
    {
        return $this->belongsTo(DairyProduction::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
