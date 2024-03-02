<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_rekening';

    protected $fillable = [
        'jenis_rekening',
        'sub_rekening',
        'nama_rekening',
    ];
}
