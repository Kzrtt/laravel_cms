<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseIngredient extends Model
{
    use HasFactory;

    protected $table = 'purchase_ingredients';
    protected $primaryKey = 'pui_id';

    public $timestamps = false;

    protected $fillable = [
        'pui_unit_price',
        'pui_quantity',
        'pui_due_date',
        'purchase_pur_id',
        'ingredients_ing_id'
    ];
}
