<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreezerTemperature extends Model
{
    use HasFactory;

    protected $fillable = [
        'recorded_by',
        'temperature',
        'recorded_at',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'temperature' => 'decimal:2',
    ];

    /**
     * Get the raw product associated with this temperature record.
     */

    /**
     * Get the worker who recorded this temperature.
     */
    public function recordedBy()
    {
        return $this->belongsTo(Worker::class, 'recorded_by');
    }
}