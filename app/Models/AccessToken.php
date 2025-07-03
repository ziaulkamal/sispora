<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    public $timestamps = false; // karena kita hanya pakai created_at

    protected $fillable = ['token', 'created_at', 'expires_at'];
}
