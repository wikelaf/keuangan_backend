<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoUser extends Model
{
    protected $table = 'saldouser_2210046';
    protected $primaryKey = 'id';

    protected $fillable = [
        'iduser_2210046',
        'jumlahsaldo_2210046',
    ];
}
