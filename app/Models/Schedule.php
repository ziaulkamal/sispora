<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'sports_sub_id',
        'venue_id',
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
        return $this->belongsTo(SportsSub::class, 'sports_sub_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function additionalSchedules()
    {
        return $this->hasMany(AdditionalSchedule::class);
    }
}
