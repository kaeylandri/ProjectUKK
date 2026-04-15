<?php

namespace Database\Seeders;

use App\Models\Aspirasi;
use Illuminate\Database\Seeder;

class AspirasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_siswa'      => 'Budi Santoso',
                'kelas'           => 'XI IPA 1',
                'kategori_sarana' => 'Proyektor / LCD',
                'lokasi'          => 'Ruang Kelas XI IPA 1, Lantai 2',
                'deskripsi'       => 'Proyektor di ruang kelas XI IPA 1 sudah tidak berfungsi dengan baik. Gambar yang ditampilkan sangat redup dan kadang-kadang tidak mau menyala sama sekali. Hal ini sangat mengganggu proses pembelajaran terutama saat guru menampilkan materi.',
                'prioritas'       => 'tinggi',
                'status'          => 'diproses',
                'umpan_balik'     => 'Laporan sudah diterima. Teknisi dijadwalkan untuk memeriksa proyektor pada hari Senin minggu depan.',
                'petugas'         => 'Pak Hendra',
                'tanggal_umpan_balik' => now()->subDays(2),
            ],
            [
                'nama_siswa'      => 'Dewi Rahayu',
                'kelas'           => 'X IPS 2',
                'kategori_sarana' => 'Toilet / Kamar Mandi',
                'lokasi'          => 'Toilet Siswa Putri, Lantai 1 dekat perpustakaan',
                'deskripsi'       => 'Salah satu kloset di toilet putri tidak bisa disiram (flush rusak) dan ada keran wastafel yang bocor. Air terus mengalir dan menyebabkan lantai selalu basah dan licin, berbahaya bagi siswa.',
                'prioritas'       => 'tinggi',
                'status'          => 'selesai',
                'umpan_balik'     => 'Perbaikan sudah dilakukan oleh tim teknisi sekolah. Flush kloset dan keran wastafel sudah diperbaiki. Terima kasih atas laporannya.',
                'petugas'         => 'Bu Sari - Sarana Prasarana',
                'tanggal_umpan_balik' => now()->subDay(),
            ],
            [
                'nama_siswa'      => 'Ahmad Fauzi',
                'kelas'           => 'XII IPA 2',
                'kategori_sarana' => 'AC / Kipas Angin',
                'lokasi'          => 'Laboratorium Komputer, Gedung B',
                'deskripsi'       => 'AC di laboratorium komputer sudah tidak dingin. Suhu ruangan sangat panas terutama siang hari sehingga komputer sering overheat dan tiba-tiba mati. Ini sangat mengganggu praktikum dan ujian berbasis komputer.',
                'prioritas'       => 'tinggi',
                'status'          => 'menunggu',
                'umpan_balik'     => null,
                'petugas'         => null,
                'tanggal_umpan_balik' => null,
            ],
            [
                'nama_siswa'      => 'Siti Nurhaliza',
                'kelas'           => 'XI IPS 1',
                'kategori_sarana' => 'Meja & Kursi',
                'lokasi'          => 'Ruang Kelas XI IPS 1, Lantai 3',
                'deskripsi'       => 'Terdapat 5 kursi siswa yang sudah rusak kakinya sehingga goyang dan tidak aman untuk diduduki. Ada juga 2 meja yang permukaannya sudah retak dan bisa melukai tangan siswa.',
                'prioritas'       => 'sedang',
                'status'          => 'menunggu',
                'umpan_balik'     => null,
                'petugas'         => null,
                'tanggal_umpan_balik' => null,
            ],
            [
                'nama_siswa'      => 'Rizky Pratama',
                'kelas'           => 'X IPA 1',
                'kategori_sarana' => 'Lapangan Olahraga',
                'lokasi'          => 'Lapangan Basket Belakang Sekolah',
                'deskripsi'       => 'Ring basket sebelah timur miringnya semakin parah dan hampir jatuh. Kondisi ini sangat berbahaya bagi siswa yang berlatih basket. Net basket juga sudah robek dan perlu diganti.',
                'prioritas'       => 'tinggi',
                'status'          => 'ditolak',
                'umpan_balik'     => 'Mohon maaf, pengaduan ini belum dapat kami tindaklanjuti saat ini karena anggaran perbaikan lapangan sudah habis. Akan dianggarkan pada tahun ajaran berikutnya. Untuk sementara penggunaan ring tersebut dilarang.',
                'petugas'         => 'Pak Darmawan - Kepala Sarana',
                'tanggal_umpan_balik' => now()->subDays(3),
            ],
        ];

        foreach ($data as $item) {
            Aspirasi::create($item);
        }
    }
}
