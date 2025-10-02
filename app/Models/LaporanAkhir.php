<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    use HasFactory;

    protected $table = 'laporan_akhir';
    protected $primaryKey = 'id_laporan_akhir';
    public $timestamps = true;

    protected $fillable = [
        'id_penempatan', 'judul', 'deskripsi_singkat', 'file_laporan', 
        'status_verifikasi', 'feedback'
    ];
    public function penempatan()
    {
        return $this->belongsTo(PenempatanPKL::class, 'id_penempatan', 'id_penempatan');
    }
}
