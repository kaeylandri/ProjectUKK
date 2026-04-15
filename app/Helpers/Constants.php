<?php


namespace App\Helpers;

class Constants
{
    public static function getKategoriSarana()
    {
        return [
            'Ruang Kelas',
            'Laboratorium',
            'Perpustakaan',
            'Toilet / Kamar Mandi',
            'Kantin',
            'Aula / Gedung Serbaguna',
            'Meja & Kursi',
            'Papan Tulis',
            'Proyektor / LCD',
            'Komputer',
            'AC / Kipas Angin',
            'Lapangan Olahraga',
            'Taman / Lingkungan',
            'Parkir',
            'Lainnya'
        ];
    }

    public static function getPrioritas()
    {
        return [
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi'
        ];
    }

    public static function getStatus()
    {
        return [
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];
    }

    public static function getStatusBadge()
    {
        return [
            'menunggu' => 'badge bg-warning',
            'diproses' => 'badge bg-info',
            'selesai' => 'badge bg-success',
            'ditolak' => 'badge bg-danger'
        ];
    }

    public static function getPrioritasBadge()
    {
        return [
            'rendah' => 'badge bg-success',
            'sedang' => 'badge bg-warning',
            'tinggi' => 'badge bg-danger'
        ];
    }

    public static function getBulan()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    public static function getHari()
    {
        return [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
    }
}