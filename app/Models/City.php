<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'city';
    protected $primaryKey = 'cit_id';
    public $timestamps = false;

    protected $fillable = [
        'cit_name',
        'cit_uf',
    ];
}
