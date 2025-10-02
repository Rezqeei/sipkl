<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status_aktif',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status_aktif' => 'boolean',
        ];
    }
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    public function isAdminInstansi()
    {
        return $this->role === 'admin_instansi';
    }

    public function isAdminBidang()
    {
        return $this->role === 'admin_bidang';
    }

    public function antrian()
    {
        return $this->hasOne(AntrianPKL::class, 'id_pengguna', 'id');
    }
    public function bidangDikelola()
    {
        return $this->hasOne(Bidang::class, 'id_admin_bidang', 'id');
    }
}
