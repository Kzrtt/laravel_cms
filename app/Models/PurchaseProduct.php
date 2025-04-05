<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    use HasFactory;

    protected $table = 'purchase_products';
    protected $primaryKey = 'prc_id';

    public $timestamps = false;

    protected $fillable = [
        'prc_unit_price',
        'prc_quantity',
        'prc_due_date',
        'purchase_pur_id',
        'products_prd_id'
    ];
}
