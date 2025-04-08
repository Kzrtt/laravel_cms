<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeUsageIngredient extends Model
{
    use HasFactory;

    protected $table = 'recipe_usage_ingredients';
    protected $primaryKey = 'rui_id';

    public $timestamps = false;

    protected $fillable = [
        'rui_total',
        'rui_quantity',
        'recipe_ingredients_rei_id',
        'recipe_usage_reu_id'
    ];
}
