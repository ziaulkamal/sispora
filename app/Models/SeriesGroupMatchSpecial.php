<?php

namespace App\Models;

use App\Models\Kontingen;
use App\Models\Sport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeriesGroupMatchSpecial extends Model
{
    use HasFactory;

    protected $table = 'series_group_match_special';

    protected $fillable = [
        'kontingenId',
        'sports_subs_id',
        'sportId',
        'group',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sportId');
    }

    public function kontingen()
    {
        return $this->belongsTo(Kontingen::class, 'kontingenId');
    }
}
