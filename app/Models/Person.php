<?php

namespace App\Models;

use App\Models\Document;
use App\Models\Kemendagri\Districts;
use App\Models\Kemendagri\Provinces;
use App\Models\Kemendagri\Regencies;
use App\Models\Kemendagri\Villages;
use App\Models\Kontingen;
use App\Models\Probability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'fullName',
        'age',
        'birthdate',
        'identityNumber',
        'familyIdentityNumber',
        'gender',
        'streetAddress',
        'religion',
        'provinceId',
        'regencieId',
        'districtId',
        'villageId',
        'kontingenId',
        'probabilityId',
        'phoneNumber',
        'email',
        'height',
        'weight',
        'documentId',
        'userId',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function athletes()
    {
        return $this->hasMany(Athlete::class, 'peopleId', 'id');
    }

    public function document()
    {
        return $this->hasOne(Document::class, 'peopleId');
    }

    public function province()
    {
        return $this->belongsTo(Provinces::class, 'provinceId');
    }
    public function regencie()
    {
        return $this->belongsTo(Regencies::class, 'regencieId');
    }
    public function district()
    {
        return $this->belongsTo(Districts::class, 'districtId');
    }
    public function village()
    {
        return $this->belongsTo(Villages::class, 'villageId');
    }
    public function kontingen()
    {
        return $this->belongsTo(Kontingen::class, 'kontingenId');
    }

    public function probability()
    {
        return $this->belongsTo(Probability::class, 'probabilityId');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'people_id');
    }
}

