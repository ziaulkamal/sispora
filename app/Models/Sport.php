<?php

namespace App\Models;

use App\Models\SportsSub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sport extends Model
{
    use HasFactory;

    protected $table = 'sports';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'imageId',
        'status',
        'specialCase',
        'userId',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function subSports()
    {
        return $this->hasMany(SportsSub::class, 'sportId');
    }
}