<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use App\Exports\AspirasiExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function getExportData()
    {
        $exportData = [
            'headers' => [
                'No',
                'NISN',
                'Nama Siswa',
                'Kelas',
                'Kategori',
                'Lokasi',
                'Deskripsi',
                'Prioritas',
                'Status',
                'Tanggal Dibuat',
                'Umpan Balik',
                'Tanggal Umpan Balik',
                'Petugas'
            ],
            'data' => []
        ];
        
        $aspirasi = Aspirasi::with('user')->get();
        
        foreach ($aspirasi as $index => $item) {
            $exportData['data'][] = [
                $index + 1,
                $item->nisn ?? '-',
                $item->nama_siswa,
                $item->kelas,
                $item->kategori_sarana,
                $item->lokasi,
                $item->deskripsi,
                ucfirst($item->prioritas),
                ucfirst($item->status),
                $item->created_at->format('d/m/Y H:i'),
                $item->umpan_balik ?? '-',
                $item->tanggal_umpan_balik ? $item->tanggal_umpan_balik->format('d/m/Y H:i') : '-',
                $item->petugas ?? '-'
            ];
        }
        
        return $exportData;
    }
    
    public function exportExcel()
    {
        $data = $this->getExportData();
        return Excel::download(new AspirasiExport($data), 'aspirasi.xlsx');
    }
    
    public function exportCSV()
    {
        $data = $this->getExportData();
        return Excel::download(new AspirasiExport($data), 'aspirasi.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    
    public function exportPDF()
    {
        $data = $this->getExportData();
        $pdf = \PDF::loadView('exports.aspirasi', compact('data'));
        return $pdf->download('aspirasi.pdf');
    }
}