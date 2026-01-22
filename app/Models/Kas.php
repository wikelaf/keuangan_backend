<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $table = 'kas_2210046';
    protected $primaryKey = 'notrans_2210046';
    public $timestamps = false;
    public $incrementing = false;        // Primary key bukan auto-increment
    protected $keyType = 'string'; 
    protected $fillable = [
        'notrans_2210046',
        'tanggal_2210046',
        'keterangan_2210046',
        'jumlahuang_2210046',
        'jenis_2210046',
        'iduser_2210046'
    ];
}
