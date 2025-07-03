<?php

namespace App\Models;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'peopleId',
        'imageProfile',
        'imageProfile_status',
        'imageProfile_note',
        'identityProfile',
        'identityProfile_status',
        'identityProfile_note',
        'familyProfile',
        'familyProfile_status',
        'familyProfile_note',
        'personalCertificate',
        'personalCertificate_status',
        'personalCertificate_note',
        'lastDiploma',
        'lastDiploma_status',
        'lastDiploma_note',
        'supportPdf',
        'supportPdf_status',
        'supportPdf_note',
        'userId',
    ];

    protected $casts = [
        'imageProfile_note' => 'string',
        'identityProfile_note' => 'string',
        'familyProfile_note' => 'string',
        'personalCertificate_note' => 'string',
        'lastDiploma_note' => 'string',
        'supportPdf_note' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'peopleId');
    }
}
