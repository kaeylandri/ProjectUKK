<?php
namespace App\Helpers;

class FilterHelper
{
    public static function getStatusOptions()
    {
        return [
            '' => 'Semua Status',
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];
    }
    
    public static function getPrioritasOptions()
    {
        return [
            '' => 'Semua Prioritas',
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi'
        ];
    }
    
    public static function getLimitOptions()
    {
        return [
            10 => '10 data',
            25 => '25 data',
            50 => '50 data',
            100 => '100 data'
        ];
    }
    
    public static function getSortByOptions()
    {
        return [
            'created_at' => 'Tanggal',
            'nama_siswa' => 'Nama Siswa',
            'kategori_sarana' => 'Kategori',
            'prioritas' => 'Prioritas',
            'status' => 'Status'
        ];
    }
    
    public static function getSortOrderOptions()
    {
        return [
            'desc' => 'Terbaru ke Terlama',
            'asc' => 'Terlama ke Terbaru'
        ];
    }
    
    public static function getAllFilterOptions()
    {
        return [
            'status' => self::getStatusOptions(),
            'prioritas' => self::getPrioritasOptions(),
            'limit' => self::getLimitOptions(),
            'sort_by' => self::getSortByOptions(),
            'sort_order' => self::getSortOrderOptions()
        ];
    }
}