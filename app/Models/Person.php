<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';
    protected $primaryKey = 'pes_id';

    public $timestamps = true;
    const CREATED_AT = 'pes_created_at';
    const UPDATED_AT = 'pes_updated_at';

    protected $fillable = [
        'pes_name',
        'pes_email',
        'pes_cpf',
        'pes_street',
        'pes_number',
        'pes_complement',
        'pes_neighborhood',
        'pes_postal_code',
        'pes_phone',
        'city_cit_id',
    ];

    public function getCity() {
        return $this->belongsTo(City::class, 'city_cit_id', 'cit_id');
    }
}
