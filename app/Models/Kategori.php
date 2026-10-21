<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'Id_Kategori';

    protected $fillable = [
        'Nama_Kategori',
        'Deskripsi_Kategori',
    ];
    public function penjual()
    {
        return $this->hasMany(penjual::class, 'Id_Kategori', 'Id_Kategori');
    }
}
