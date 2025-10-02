<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPKL extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pkl';
    protected $primaryKey = 'id_dokumen';
    public $timestamps = true;

    protected $fillable = [
        'id_antrian',
        'file_surat_pengantar',
        'file_surat_bankesbangpol',
        'status_verifikasi',
        'catatan_revisi'
    ];
    public function antrian()
    {
        return $this->belongsTo(AntrianPKL::class, 'id_antrian', 'id_antrian');
    }
}
