<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'nama_bidang',
        'id_admin_bidang',
    ];
    public function adminBidang()
    {
        return $this->belongsTo(User::class, 'id_admin_bidang', );
    }
    public function penempatan()
    {
        return $this->hasMany(PenempatanPKL::class, 'id_bidang', );
    }
}
