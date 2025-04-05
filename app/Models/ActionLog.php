<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    use HasFactory;

    protected $table = 'action_logs';
    protected $primaryKey = 'alg_id';

    public $timestamps = false;

    protected $fillable = [
        'alg_model',
        'alg_action',
        'alg_description',
        'alg_object',
        'alg_date',
        'alg_time',
        'alg_model_id',
        'users_usr_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'users_usr_id', 'usr_id');
    }
}
