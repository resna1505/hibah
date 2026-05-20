<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class TahapanHibah extends Model
{
    protected $table = 'tahapan_hibah_m';

    protected $fillable = ['urutan', 'kode', 'nama', 'deskripsi', 'icon'];
}
