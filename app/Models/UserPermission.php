<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = 'user_permissions';
    protected $primaryKey = 'usp_id';
    public $timestamps = false;

    protected $fillable = [
        'usp_area',
        'usp_action',
    ];

    public function getUser() {
        return $this->belongsTo(Users::class, 'users_usr_id', 'usr_id');
    }
}
