<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    use HasFactory;

    protected $table = 'measurement_units';
    protected $primaryKey = 'msu_id';
    public $timestamps = false;

    protected $fillable = [
        'msu_name',
        'msu_unit'    
    ];
}
