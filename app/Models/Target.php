<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_target';

    protected $fillable = [
        'id_rekening',
        'tahun',
        'jumlah_target',
    ];
}
