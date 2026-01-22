<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KirimUang extends Model
{
    protected $table = 'kirimuang_2210046';
    protected $primaryKey = 'noref_2210046';
    protected $fillable = [
        'noref_2210046',
        'tglkirim_2210046',
        'dari_iduser_2210046',
        'ke_iduser_2210046',
        'jumlahuang_2210046',
    ];
    public $incrementing = false;
    public $timestamps = false;
}
