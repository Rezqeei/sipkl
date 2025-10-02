<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMingguan extends Model
{
    use HasFactory;

    protected $table = 'laporan_mingguan';
    protected $primaryKey = 'id_laporan_mingguan';
    public $timestamps = true;

    protected $fillable = [
        'id_penempatan', 'minggu_ke', 'isi_laporan', 'file_laporan', 
        'status_verifikasi', 'feedback'
    ];
    public function penempatan()
    {
        return $this->belongsTo(PenempatanPKL::class, 'id_penempatan', 'id_penempatan');
    }
}
