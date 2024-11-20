<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKaryawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_laporan',
        'isi_laporan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
