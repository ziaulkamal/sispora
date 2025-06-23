<?php

namespace App\Models;

use App\Models\Kontingen;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Athlete extends Model
{
    use HasFactory;

    protected $table = 'athletes';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'peopleId',
        'kontingenId',
        'sportsSubId',
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

    public function kontingen()
    {
        return $this->belongsTo(Kontingen::class, 'kontingenId');
    }
}
