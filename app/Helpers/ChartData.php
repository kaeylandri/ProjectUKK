<?php


namespace App\Helpers;

use App\Models\Aspirasi;
use App\Models\User;

class ChartData
{
    public static function getStatusChart()
    {
        $data = [
            'labels' => ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
            'datasets' => [
                [
                    'label' => 'Jumlah Aspirasi',
                    'data' => [
                        Aspirasi::where('status', 'menunggu')->count(),
                        Aspirasi::where('status', 'diproses')->count(),
                        Aspirasi::where('status', 'selesai')->count(),
                        Aspirasi::where('status', 'ditolak')->count(),
                    ],
                    'backgroundColor' => [
                        '#f59e0b',
                        '#3b82f6',
                        '#10b981',
                        '#ef4444'
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2
                ]
            ]
        ];
        
        return $data;
    }
    
    public static function getPrioritasChart()
    {
        $data = [
            'labels' => ['Rendah', 'Sedang', 'Tinggi'],
            'datasets' => [
                [
                    'label' => 'Jumlah Aspirasi',
                    'data' => [
                        Aspirasi::where('prioritas', 'rendah')->count(),
                        Aspirasi::where('prioritas', 'sedang')->count(),
                        Aspirasi::where('prioritas', 'tinggi')->count(),
                    ],
                    'backgroundColor' => [
                        '#10b981',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2
                ]
            ]
        ];
        
        return $data;
    }
    
    public static function getMonthlyChart($year = null)
    {
        $year = $year ?? date('Y');
        $months = [];
        $data = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Constants::getBulan()[$i];
            $data[] = Aspirasi::whereYear('created_at', $year)
                ->whereMonth('created_at', $i)
                ->count();
        }
        
        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => "Jumlah Aspirasi Tahun {$year}",
                    'data' => $data,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#1e40af',
                    'borderWidth' => 2,
                    'fill' => false,
                    'tension' => 0.4
                ]
            ]
        ];
    }
    
    public static function getKategoriChart($limit = 10)
    {
        $kategoriData = Aspirasi::select('kategori_sarana', \DB::raw('count(*) as total'))
            ->groupBy('kategori_sarana')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();
        
        $colors = [
            '#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6',
            '#ec4899', '#06b6d4', '#84cc16', '#f97316', '#6366f1'
        ];
        
        $data = [
            'labels' => $kategoriData->pluck('kategori_sarana')->toArray(),
            'datasets' => [
                [
                    'label' => 'Jumlah Aspirasi',
                    'data' => $kategoriData->pluck('total')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $kategoriData->count()),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2
                ]
            ]
        ];
        
        return $data;
    }
}