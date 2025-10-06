<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\LaporanMingguan;
use App\Models\LaporanAkhir;
use App\Models\SuratKeterangan;

class PenempatanPKL extends Model
{
    use HasFactory;

    protected $table = 'penempatan_pkl';
    protected $primaryKey = 'id_penempatan';
    public $timestamps = true;

    protected $fillable = [
        'id_antrian',
        'id_pengguna',
        'id_bidang',
        'id_pembimbing',
        'status_pkl'
    ];

    public function antrian()
    {
        return $this->belongsTo(AntrianPKL::class, 'id_antrian', 'id_antrian');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'id_bidang', 'id');
    }
    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'id_pembimbing');
    }
    public function laporanMingguan()
    {
        return $this->hasMany(LaporanMingguan::class, 'id_penempatan', 'id_penempatan');
    }

    public function laporanAkhir()
    {
        return $this->hasOne(LaporanAkhir::class, 'id_penempatan', 'id_penempatan');
    }

    public function suratKeterangan()
    {
        return $this->hasOne(SuratKeterangan::class, 'id_penempatan', 'id_penempatan');
    }
}
