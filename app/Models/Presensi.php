<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'datang', 'pulang', 'lama_jam_kerja'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
