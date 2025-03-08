<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRepresentedAgent extends Model
{
    use HasFactory;

    protected $table = 'user_represented_agents';
    protected $primaryKey = 'ura_id';
    public $timestamps = false;

    protected $fillable = [
        'ura_type',
        'represented_agent_id',
        'users_usr_id'
    ];

    public function getUser() {
        return $this->belongsTo(Users::class, 'users_usr_id', 'usr_id');
    }
}
