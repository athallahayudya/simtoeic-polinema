<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnouncementModel;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Announcement 1
        AnnouncementModel::firstOrCreate(
            ['title' => 'Selamat Datang di Sistem Ujian Baru'],
            [
                'content' => 'Kami dengan senang hati mengumumkan peluncuran sistem manajemen ujian baru. Silahkan masuk ke akun Anda untuk menjelajahi semua fitur.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->format('Y-m-d')
            ]
        );

        // Announcement 2
        AnnouncementModel::firstOrCreate(
            ['title' => 'Pemberitahuan Pemeliharaan Sistem'],
            [
                'content' => 'Sistem akan menjalani pemeliharaan pada akhir pekan mendatang. Harap antisipasi gangguan layanan antara Sabtu pukul 22:00 sampai Minggu pukul 02:00.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->addDays(3)->format('Y-m-d')
            ]
        );

        // Announcement 3
        AnnouncementModel::firstOrCreate(
            ['title' => 'Jadwal Ujian Mendatang'],
            [
                'content' => 'Jadwal untuk putaran ujian berikutnya telah dipublikasikan. Silahkan periksa bagian jadwal ujian untuk detailnya.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->subDays(2)->format('Y-m-d')
            ]
        );

        // Announcement 4
        AnnouncementModel::firstOrCreate(
            ['title' => 'Fitur Baru: Unduh Sertifikat'],
            [
                'content' => 'Kami telah menambahkan fitur baru yang memungkinkan mahasiswa mengunduh sertifikat mereka langsung dari profil. Fitur ini akan tersedia mulai minggu depan.',
                'announcement_status' => 'draft',
                'announcement_date' => Carbon::now()->addDays(7)->format('Y-m-d')
            ]
        );

        // Announcement 5
        AnnouncementModel::firstOrCreate(
            ['title' => 'Jadwal Libur'],
            [
                'content' => 'Kantor akan tutup selama libur nasional dari 1 Mei hingga 5 Mei. Layanan online tetap beroperasi.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->addDays(10)->format('Y-m-d')
            ]
        );

        // Announcement 6 - Recent Draft
        AnnouncementModel::firstOrCreate(
            ['title' => 'Pembaruan Fasilitas Kampus'],
            [
                'content' => 'Beberapa fasilitas kampus termasuk laboratorium komputer dan perpustakaan akan direnovasi bulan depan. Pengaturan alternatif akan diumumkan segera.',
                'announcement_status' => 'draft',
                'announcement_date' => Carbon::now()->addDays(14)->format('Y-m-d')
            ]
        );

        // Announcement 7 - Old Published
        AnnouncementModel::firstOrCreate(
            ['title' => 'Hasil Ujian Sebelumnya'],
            [
                'content' => 'Hasil untuk siklus ujian sebelumnya telah dipublikasikan. Mahasiswa dapat melihat hasil mereka di dashboard.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->subDays(30)->format('Y-m-d')
            ]
        );
    }
}
