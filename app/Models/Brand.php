<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'brands';
    protected $primaryKey = 'brd_id';
    public $timestamps = false;

    protected $fillable = [
        'brd_name'
    ];
}
