<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';
    protected $primaryKey = 'prf_id';
    public $timestamps = true;

    const CREATED_AT = 'prf_created_at';
    const UPDATED_AT = 'prf_updated_at';

    protected $fillable = [
        'prf_name',
        'prf_status',
        'prf_level',
    ];
}
