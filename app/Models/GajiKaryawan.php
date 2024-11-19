<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GajiKaryawan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jabatan_id', 'tanggal_gaji', 'jumlah_hadir', 'gaji_pokok'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
