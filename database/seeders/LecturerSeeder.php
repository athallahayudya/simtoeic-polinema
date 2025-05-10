<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserModel;
use App\Models\LecturerModel;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // LECTURER 1
        $user1 = UserModel::firstOrCreate(
            ['identity_number' => '199001010001'],
            [
                'role' => 'lecturer',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567001',
            ]
        );
        
        LecturerModel::firstOrCreate(
            ['user_id' => $user1->user_id],
            [
                'name' => 'Dr. Ahmad Kurniawan',
                'nidn' => '199001010001000001', // 18 characters
                'ktp_scan' => 'storage/lecturer/ktp/199001010001.jpg',
                'photo' => 'storage/lecturer/photos/199001010001.jpg',
                'home_address' => 'Jl. Soekarno Hatta No. 101, Malang',
                'current_address' => 'Jl. Veteran No. 101, Malang',
            ]
        );

        // LECTURER 2
        $user2 = UserModel::firstOrCreate(
            ['identity_number' => '199001010002'],
            [
                'role' => 'lecturer',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567002',
            ]
        );
        
        LecturerModel::firstOrCreate(
            ['user_id' => $user2->user_id],
            [
                'name' => 'Prof. Siti Rahayu',
                'nidn' => '199001010002000002', // 18 characters
                'ktp_scan' => 'storage/lecturer/ktp/199001010002.jpg',
                'photo' => 'storage/lecturer/photos/199001010002.jpg',
                'home_address' => 'Jl. Tlogomas No. 202, Malang',
                'current_address' => 'Jl. Dieng No. 202, Malang',
            ]
        );

        // LECTURER 3
        $user3 = UserModel::firstOrCreate(
            ['identity_number' => '199001010003'],
            [
                'role' => 'lecturer',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567003',
            ]
        );
        
        LecturerModel::firstOrCreate(
            ['user_id' => $user3->user_id],
            [
                'name' => 'Dr. Budi Santoso',
                'nidn' => '199001010003000003', // 18 characters
                'ktp_scan' => 'storage/lecturer/ktp/199001010003.jpg',
                'photo' => 'storage/lecturer/photos/199001010003.jpg',
                'home_address' => 'Jl. Semanggi No. 303, Malang',
                'current_address' => 'Jl. Gajayana No. 303, Malang',
            ]
        );

        // LECTURER 4
        $user4 = UserModel::firstOrCreate(
            ['identity_number' => '199001010004'],
            [
                'role' => 'lecturer',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567004',
            ]
        );
        
        LecturerModel::firstOrCreate(
            ['user_id' => $user4->user_id],
            [
                'name' => 'Dr. Dewi Lestari',
                'nidn' => '199001010004000004', // 18 characters
                'ktp_scan' => 'storage/lecturer/ktp/199001010004.jpg',
                'photo' => 'storage/lecturer/photos/199001010004.jpg',
                'home_address' => 'Jl. Panjaitan No. 404, Malang',
                'current_address' => 'Jl. Sukarno No. 404, Malang',
            ]
        );

        // LECTURER 5
        $user5 = UserModel::firstOrCreate(
            ['identity_number' => '199001010005'],
            [
                'role' => 'lecturer',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567005',
            ]
        );
        
        LecturerModel::firstOrCreate(
            ['user_id' => $user5->user_id],
            [
                'name' => 'Prof. Hadi Wijaya',
                'nidn' => '199001010005000005', // 18 characters
                'ktp_scan' => 'storage/lecturer/ktp/199001010005.jpg',
                'photo' => 'storage/lecturer/photos/199001010005.jpg',
                'home_address' => 'Jl. MT Haryono No. 505, Malang',
                'current_address' => 'Jl. Sumbersari No. 505, Malang',
            ]
        );
    }
}