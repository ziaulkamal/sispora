<?php

namespace App\Models;

use App\Models\AdditionalScheduleRegular;
use App\Models\AdditionalScheduleSpecial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Schedule extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $table = 'schedules';

    protected $fillable = [
        'id',
        'date',
        'start_time',
        'end_time',
        'sportsSubId',
        'venuesId',
        'status',
        'user_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id = $model->id ?? Str::uuid());
    }

    public function sportsSub()
    {
        return $this->belongsTo(SportsSub::class, 'sportsSubId');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venuesId');
    }

    public function additionalSchedulesSpecial()
    {
        return $this->hasMany(AdditionalScheduleSpecial::class, 'schedulesId');
    }

    public function additionalSchedulesRegular()
    {
        return $this->hasMany(AdditionalScheduleRegular::class, 'schedulesId');
    }


}
