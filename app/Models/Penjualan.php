<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'faktur';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'faktur',
        'item',
        'dibayar',
        'kd_ptg'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(Petugas::class,'kd_ptg');
    }

    
}
