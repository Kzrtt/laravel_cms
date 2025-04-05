<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeUsagePurchase extends Model
{
    use HasFactory;

    protected $table = 'recipe_usage_purchases';
    protected $primaryKey = 'rup_id';

    public $timestamps = false;

    protected $fillable = [
        'purchase_pur_id',
        'recipe_usage_reu_id',
    ];

}
