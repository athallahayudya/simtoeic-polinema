<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaqModel;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // FAQ 1
        FaqModel::firstOrCreate(
            ['question' => 'Bagaimana cara mendaftar ujian?'],
            [
                'answer' => 'Untuk mendaftar ujian, silakan masuk ke akun Anda, pilih menu "Pendaftaran Ujian" dan ikuti langkah-langkah yang ditampilkan. Pastikan Anda memenuhi semua persyaratan sebelum mendaftar.'
            ]
        );

        // FAQ 2
        FaqModel::firstOrCreate(
            ['question' => 'Bagaimana saya bisa mengubah kata sandi saya?'],
            [
                'answer' => 'Untuk mengubah kata sandi, masuk ke akun Anda, pilih menu "Profil". Di sana Anda dapat mengubah kata sandi dengan memasukkan kata sandi lama dan kata sandi baru.'
            ]
        );

        // FAQ 3
        FaqModel::firstOrCreate(
            ['question' => 'Bagaimana cara melihat hasil ujian?'],
            [
                'answer' => 'Hasil ujian dapat dilihat di menu "Hasil Ujian" setelah Anda masuk ke akun. Hasil biasanya dipublikasikan dalam waktu 3-5 hari kerja setelah ujian selesai.'
            ]
        );
        
        // FAQ 4
        FaqModel::firstOrCreate(
            ['question' => 'Apakah saya bisa mengulang ujian jika gagal?'],
            [
                'answer' => 'Ya, Anda dapat mengulang ujian jika gagal, dengan mendaftar ke ujian mandiri/berbayar.'
            ]
        );

        // FAQ 5
        FaqModel::firstOrCreate(
            ['question' => 'Berapa nilai minimum untuk lulus ujian?'],
            [
                'answer' => 'Nilai minimum untuk lulus ujian adalah < 500.'
            ]
        );

    }
}