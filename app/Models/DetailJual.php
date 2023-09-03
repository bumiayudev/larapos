<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailJual extends Model
{
   protected $table = 'detail_jual';
   public $incrementing = false;
   public $timestamps = false;

   protected $fillable = [
        'faktur',
        'kd_brg',
        'nm_brg',
        'hrg_jual',
        'subtotal'
   ];
}
