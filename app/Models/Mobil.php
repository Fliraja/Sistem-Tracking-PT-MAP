<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobils';

    protected $fillable = [
        'plat',
        'jenis',
    ];

    // Relasi: satu mobil bisa memiliki banyak attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'mobil_id');
    }
}
