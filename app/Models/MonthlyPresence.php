<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonthlyPresence extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'month', 'year', 'jumlah_hadir'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
