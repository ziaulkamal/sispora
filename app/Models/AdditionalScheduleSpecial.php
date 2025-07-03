<?php

namespace App\Models;

use App\Models\Kontingen;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdditionalScheduleSpecial extends Model
{
    use HasFactory;

    protected $table = 'additional_schedules_special';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'schedulesId',
        'match',
        'group',
        'kontingenId',
        'score',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedulesId');
    }

    public function kontingen()
    {
        return $this->belongsTo(Kontingen::class, 'kontingenId');
    }
}
