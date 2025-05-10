<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserModel;
use App\Models\AlumniModel;
use Illuminate\Support\Facades\Hash;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ALUMNI 1
        $user1 = UserModel::firstOrCreate(
            ['identity_number' => '8001010001'],
            [
                'role' => 'alumni',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567901',
            ]
        );
        
        AlumniModel::firstOrCreate(
            ['user_id' => $user1->user_id],
            [
                'name' => 'Agus Purnomo',
                'nik' => '3500010101880001',  // 16 characters
                'ktp_scan' => 'storage/alumni/ktp/8001010001.jpg',
                'photo' => 'storage/alumni/photos/8001010001.jpg',
                'home_address' => 'Jl. Ahmad Yani No. 101, Malang',
                'current_address' => 'Jl. Soekarno Hatta No. 201, Malang',
            ]
        );

        // ALUMNI 2
        $user2 = UserModel::firstOrCreate(
            ['identity_number' => '8001010002'],
            [
                'role' => 'alumni',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567902',
            ]
        );
        
        AlumniModel::firstOrCreate(
            ['user_id' => $user2->user_id],
            [
                'name' => 'Dewi Rahmawati',
                'nik' => '3500010102880002',  // 16 characters
                'ktp_scan' => 'storage/alumni/ktp/8001010002.jpg',
                'photo' => 'storage/alumni/photos/8001010002.jpg',
                'home_address' => 'Jl. Tlogomas No. 55, Malang',
                'current_address' => 'Jl. Gajayana No. 78, Malang',
            ]
        );

        // ALUMNI 3
        $user3 = UserModel::firstOrCreate(
            ['identity_number' => '8001010003'],
            [
                'role' => 'alumni',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567903',
            ]
        );
        
        AlumniModel::firstOrCreate(
            ['user_id' => $user3->user_id],
            [
                'name' => 'Faisal Rahman',
                'nik' => '3500010103880003',  // 16 characters
                'ktp_scan' => 'storage/alumni/ktp/8001010003.jpg',
                'photo' => 'storage/alumni/photos/8001010003.jpg',
                'home_address' => 'Jl. Veteran No. 123, Malang',
                'current_address' => 'Jl. Dinoyo No. 45, Malang',
            ]
        );

        // ALUMNI 4
        $user4 = UserModel::firstOrCreate(
            ['identity_number' => '8001010004'],
            [
                'role' => 'alumni',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567904',
            ]
        );
        
        AlumniModel::firstOrCreate(
            ['user_id' => $user4->user_id],
            [
                'name' => 'Hana Permata',
                'nik' => '3500010104880004',  // 16 characters
                'ktp_scan' => 'storage/alumni/ktp/8001010004.jpg',
                'photo' => 'storage/alumni/photos/8001010004.jpg',
                'home_address' => 'Jl. MT Haryono No. 90, Malang',
                'current_address' => 'Jl. Sukarno No. 77, Malang',
            ]
        );

        // ALUMNI 5
        $user5 = UserModel::firstOrCreate(
            ['identity_number' => '8001010005'],
            [
                'role' => 'alumni',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567905',
            ]
        );
        
        AlumniModel::firstOrCreate(
            ['user_id' => $user5->user_id],
            [
                'name' => 'Irfan Pratama',
                'nik' => '3500010105880005',  // 16 characters
                'ktp_scan' => 'storage/alumni/ktp/8001010005.jpg',
                'photo' => 'storage/alumni/photos/8001010005.jpg',
                'home_address' => 'Jl. Danau Sentani No. 15, Malang',
                'current_address' => 'Jl. Semeru No. 30, Malang',
            ]
        );
    }
}