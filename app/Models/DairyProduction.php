<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DairyProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'mixer_id',
        'supervisor_id',
        'number_of_trays',
        'batch_number',
        'baking_temp',
        'baking_time',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function mixer()
    {
        return $this->belongsTo(Worker::class, 'mixer_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Worker::class, 'supervisor_id');
    }

    public function helpers()
    {
        return $this->hasMany(ProductionHelper::class);
    }
}
