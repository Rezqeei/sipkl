<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SuratKeterangan extends Model
{
    use HasFactory;

    protected $table = 'surat_keterangan';
    protected $primaryKey = 'id_surat';
    public $timestamps = true;

    protected $fillable = [
        'id_penempatan', 'nomor_surat', 'tanggal_terbit', 'file_surat'
    ];
    public function penempatan()
    {
        return $this->belongsTo(PenempatanPKL::class, 'id_penempatan', 'id_penempatan');
    }
}
