<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';
    protected $fillable = ['peminjam_id', 'peralatan_id', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'keterangan'];

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'peminjam_id');
    }

    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'peralatan_id');
    }
}