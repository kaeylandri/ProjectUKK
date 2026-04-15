<?php
// app/Models/Aspirasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi';

    protected $fillable = [
        'user_id', 
        'nisn',
        'nama_siswa', 
        'kelas', 
        'kategori_sarana',
        'lokasi', 
        'deskripsi', 
        'foto', 
        'prioritas', 
        'status',
        'umpan_balik', 
        'tanggal_umpan_balik', 
        'petugas',
    ];

    protected $casts = [
        'tanggal_umpan_balik' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'b-wait', 
            'diproses' => 'b-proc',
            'selesai'  => 'b-done', 
            'ditolak'  => 'b-rej',
            default    => 'b-wait',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'Menunggu', 
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',  
            'ditolak'  => 'Ditolak',
            default    => 'Menunggu',
        };
    }

    public function getPrioritasLabelAttribute(): string
    {
        return match($this->prioritas) {
            'rendah' => 'Rendah', 
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi', 
            default  => 'Sedang',
        };
    }

    public function getPrioritasBadgeAttribute(): string
    {
        return match($this->prioritas) {
            'rendah' => 'b-lo',
            'sedang' => 'b-med',
            'tinggi' => 'b-hi',
            default => 'b-med',
        };
    }
    
    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}