<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }

    public function absen()
    {
        return $this->hasMany(Absen::class);
    }
}
