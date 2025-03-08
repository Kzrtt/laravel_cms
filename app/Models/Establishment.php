<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $table = 'establishments';
    protected $primaryKey = 'est_id';

    public $timestamps = true;
    const CREATED_AT = 'est_created_at';
    const UPDATED_AT = 'est_updated_at';

    protected $fillable = [
        'est_fantasy',
        'est_cnpj',
    ];
}
