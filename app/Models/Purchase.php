<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';
    protected $primaryKey = 'pur_id';

    public $timestamps = true;
    const CREATED_AT = 'pur_created_at';
    const UPDATED_AT = 'pur_updated_at';

    protected $fillable = [
        'pur_total',
        'pur_name',
        'pur_payment_method',
        'suppliers_sup_id',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'suppliers_sup_id', 'sup_id');
    }

    public function products() {
        return $this->belongsToMany(
            Product::class,
            'purchase_products',
            'purchase_pur_id',
            'products_prd_id',
        );
    }
}
