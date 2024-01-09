<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function jadwal()
    {
        return $this->hasMany(JadwalPiket::class, 'hari_id', 'id');
    }

    public function piket()
    {
        return $this->hasMany(JadwalPiket::class, 'hari_id', 'id');
    }
}
