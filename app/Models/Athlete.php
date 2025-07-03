<?php

namespace App\Models;

use App\Models\Kontingen;
use App\Models\Person;
use App\Models\SportsSub;
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

    public function sportsSub()
    {
        return $this->belongsTo(SportsSub::class, 'sportsSubId', 'id');
    }

}
