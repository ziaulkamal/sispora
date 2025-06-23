<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class AdditionalSchedule extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $table = 'additional_schedules';

    protected $fillable = [
        'id',
        'schedule_id',
        'match',
        'kontingen_id',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id = $model->id ?? Str::uuid());
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function kontingen()
    {
        return $this->belongsTo(Kontingen::class, 'kontingen_id');
    }
}
