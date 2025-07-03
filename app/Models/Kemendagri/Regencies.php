<?php

namespace App\Models\Kemendagri;

use App\Models\Kontingen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regencies extends Model
{
    protected $table = 'reg_regencies';
    protected $fillable = [
        'id',
        'province_id',
        'name',
    ];

    public function kontingens()
    {
        return $this->hasMany(Kontingen::class, 'regencies_id', 'id');
    }
}
