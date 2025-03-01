<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'usr_id';
    public $timestamps = true;

    const CREATED_AT = 'usr_created_at';
    const UPDATED_AT = 'usr_updated_at';

    protected $fillable = [
        'usr_email',
        'usr_password',
        'usr_level',
    ];

    public function getPerson() {
        return $this->belongsTo(Person::class, 'persons_pes_id', 'pes_id');
    }

    public function getProfile() {
        return $this->belongsTo(Profile::class, 'profiles_prf_id', 'prf_id');
    }

    public function getRepresentedAgent() {
        return $this->hasOne(UserRepresentedAgent::class, 'users_usr_id', 'usr_id');
    }

}
