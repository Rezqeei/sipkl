<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $table = 'pembimbings';
    public $timestamps = true;

    protected $fillable = [
        'nama_pembimbing',
    ];

    public function penempatan()
    {
        return $this->hasMany(PenempatanPKL::class, 'id_pembimbing');
    }
}
