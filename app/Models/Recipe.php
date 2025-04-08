<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';
    protected $primaryKey = 'rec_id';

    public $timestamps = true;
    const CREATED_AT = 'rec_created_at';
    const UPDATED_AT = 'rec_updated_at';

    protected $fillable = [
        'rec_name',
        'rec_preparation',
        'rec_preparation_time',
        'rec_portions',
        'establishment_est_id'
    ];

    public function recipeIngredients() {
        return $this->hasMany(RecipeIngredient::class, 'recipe_rec_id', 'rec_id');
    }

    public function ingredients() {
        return $this->belongsToMany(
            Ingredient::class,
            'recipe_products',
            'recipe_rec_id',
            'products_prd_id',
        );
    }
}
