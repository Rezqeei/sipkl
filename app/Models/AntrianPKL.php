<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianPKL extends Model
{
     use HasFactory;

    protected $table = 'antrian_pkl';
    protected $primaryKey = 'id_antrian';
    public $timestamps = true;

    
    protected $fillable = [
        'id_pengguna', 'nim', 'jurusan', 'nama_kampus', 'alamat', 
        'jumlah_orang', 'tgl_mulai', 'tgl_berakhir', 'kontak_aktif', 
        'status_antrian', 'alasan_penolakan'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }

    public function dokumen()
    {
        return $this->hasOne(DokumenPKL::class, 'id_antrian', 'id_antrian');
    }

    public function penempatan()
    {
        return $this->hasOne(PenempatanPKL::class, 'id_antrian', 'id_antrian');
    }
}
