<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'prd_id';

    public $timestamps = true;
    const CREATED_AT = 'prd_created_at';
    const UPDATED_AT = 'prd_updated_at';

    protected $fillable = [
        'prd_name',
        'prd_description',
        'measurement_units_msu_id'
    ];

    public function measurementUnit() {
        return $this->belongsTo(MeasurementUnit::class, 'measurement_units_msu_id', 'msu_id');
    }
}
