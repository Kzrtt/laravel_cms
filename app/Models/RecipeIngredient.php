<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    protected $table = 'recipe_ingredients';
    protected $primaryKey = 'rei_id';

    public $timestamps = false;

    protected $fillable = [
        'rei_quantity',
        'recipe_rec_id',
        'ingredients_ing_id',
        'measurement_unit_msu_id'
    ];

    public function ingredient() {
        return $this->belongsTo(Ingredient::class, 'ingredients_ing_id', 'ing_id');
    }

    public function measurementUnit() {
        return $this->belongsTo(MeasurementUnit::class, 'measurement_unit_msu_id', 'msu_id');
    }
}
