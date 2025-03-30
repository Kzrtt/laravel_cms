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
        'users_usr_id'
    ];

    public function getUser() {
        return $this->belongsTo(User::class, 'users_usr_id', 'usr_id');
    }
}
