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
        'sportId',
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
        return $this->belongsTo(Sport::class, 'sportId', 'id');
    }

}
