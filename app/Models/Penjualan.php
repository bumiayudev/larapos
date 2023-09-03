<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'faktur';
    protected $keyType = 'string';
    protected $timestamps = false;
    protected $incrementing = false;

    protected $fillable = [
        'faktur',
        'item',
        'dibayar',
        'kd_ptg'
    ];
}
