<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeProduct extends Model
{
    use HasFactory;

    protected $table = 'recipe_products';
    protected $primaryKey = 'rep_id';

    public $timestamps = false;

    protected $fillable = [
        'rep_quantity',
        'recipe_rec_id',
        'products_prd_id',
        'measurement_unit_msu_id'
    ];
}
