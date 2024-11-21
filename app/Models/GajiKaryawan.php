<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GajiKaryawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jabatan_id',
        'tanggal_gaji',
        'jumlah_hadir',
        'jumlah_izin',
        'jumlah_sakit',
        'jumlah_wfh',
        'jumlah_alfa',
        'jumlah_hari_kerja',
        'gaji_pokok',
        'gaji_per_hari',
        'bonus',
        'potongan',
        'total_gaji',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    // Relasi untuk user yang menginput gaji
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
