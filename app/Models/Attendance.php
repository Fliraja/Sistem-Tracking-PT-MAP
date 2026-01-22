<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'mobil_id',
        'user_id',
        'tanggal_berangkat',
        'supplier',
        'tujuan',
        'panjang',
        'lebar',
        'tinggi',
        'plus',
        'volume',
        'foto_berangkat',
        'foto_sampai',
        'status',
    ];

    // Relasi: attendance milik satu mobil
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    // Relasi: attendance milik satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
