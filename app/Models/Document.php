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
        'familyProfile',
        'selfieProfile',
        'path',
        'imageId',
        'extra',
        'userId',
    ];

    protected $casts = [
        'extra' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'peopleId');
    }
}
