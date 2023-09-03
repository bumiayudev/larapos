<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'kd_ptg';
    protected $keyType = 'string';
    protected $incrementing = false;
    protected $timestamps = false;

    protected $fillable = ['kd_ptg', 'nm_ptg', 'pass'];
}
