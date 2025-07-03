<?php

namespace App\Models;

use App\Models\Athlete;
use App\Models\Kemendagri\Regencies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kontingen extends Model
{
    use HasFactory;

    protected $table = 'kontingens';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'province_id',
        'regencies_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }


    /**
     * Get the user that owns the Kontingen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency()
    {
        return $this->belongsTo(Regencies::class, 'regencies_id', 'id');
    }
}