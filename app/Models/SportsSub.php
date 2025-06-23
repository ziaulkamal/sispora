<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class SportsSub extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $table = 'sports_subs';

    protected $fillable = [
        'id',
        'sport_id',
        'add_player_id',
        'add_match_id',
        'name',
        'label',
        'image_id',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = $model->id ?? Str::uuid()->toString();
        });
    }

    // RELATIONS
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }

    public function additionalPlayer()
    {
        return $this->belongsTo(AdditionalPlayer::class, 'add_player_id');
    }

    public function additionalMatch()
    {
        return $this->belongsTo(AdditionalMatch::class, 'add_match_id');
    }
}
