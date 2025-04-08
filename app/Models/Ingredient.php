<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = 'ingredients';
    protected $primaryKey = 'ing_id';

    public $timestamps = true;
    const CREATED_AT = 'ing_created_at';
    const UPDATED_AT = 'ing_updated_at';

    protected $fillable = [
        'ing_name',
        'ing_description',
        'ing_current_stock',
        'ing_min_stock',
        'measurement_units_msu_id',
        'establishment_est_id'
    ];

    public function measurementUnit() {
        return $this->belongsTo(MeasurementUnit::class, 'measurement_units_msu_id', 'msu_id');
    }
}
