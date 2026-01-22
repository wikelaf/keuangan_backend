<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MintaUang extends Model
{
    protected $table = 'mintauang_2210046';
    protected $primaryKey = 'noref_2210046';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'noref_2210046',
        'tglminta_2210046',
        'dari_iduser_2210046',
        'ke_iduser_2210046',
        'jumlahuang_2210046',
        'stt_2210046',
        'tglsukses_2210046',
    ];
}
