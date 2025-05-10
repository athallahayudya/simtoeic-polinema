<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserModel;
use App\Models\StaffModel;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // STAFF 1
        $user1 = UserModel::create([
            'role' => 'staff',
            'identity_number' => '9001010001',
            'password' => Hash::make('password123'),
            'exam_status' => 'not_yet',
            'phone_number' => '081234567101',
        ]);
        
        StaffModel::create([
            'user_id' => $user1->user_id,
            'name' => 'Rahmat Hidayat',
            'nip' => '9001010001', // 10 characters
            'ktp_scan' => 'storage/staff/ktp/9001010001.jpg',
            'photo' => 'storage/staff/photos/9001010001.jpg',
            'home_address' => 'Jl. Semeru No. 101, Malang',
            'current_address' => 'Jl. Merdeka No. 101, Malang',
        ]);

        // STAFF 2
        $user2 = UserModel::create([
            'role' => 'staff',
            'identity_number' => '9001010002',
            'password' => Hash::make('password123'),
            'exam_status' => 'not_yet',
            'phone_number' => '081234567102',
        ]);
        
        StaffModel::create([
            'user_id' => $user2->user_id,
            'name' => 'Anisa Putri',
            'nip' => '9001010002', // 10 characters
            'ktp_scan' => 'storage/staff/ktp/9001010002.jpg',
            'photo' => 'storage/staff/photos/9001010002.jpg',
            'home_address' => 'Jl. Kawi No. 202, Malang',
            'current_address' => 'Jl. Ijen No. 202, Malang',
        ]);

        // STAFF 3
        $user3 = UserModel::create([
            'role' => 'staff',
            'identity_number' => '9001010003',
            'password' => Hash::make('password123'),
            'exam_status' => 'not_yet',
            'phone_number' => '081234567103',
        ]);
        
        StaffModel::create([
            'user_id' => $user3->user_id,
            'name' => 'Bambang Sutrisno',
            'nip' => '9001010003', // 10 characters
            'ktp_scan' => 'storage/staff/ktp/9001010003.jpg',
            'photo' => 'storage/staff/photos/9001010003.jpg',
            'home_address' => 'Jl. Merapi No. 303, Malang',
            'current_address' => 'Jl. Bromo No. 303, Malang',
        ]);

        // STAFF 4
        $user4 = UserModel::create([
            'role' => 'staff',
            'identity_number' => '9001010004',
            'password' => Hash::make('password123'),
            'exam_status' => 'not_yet',
            'phone_number' => '081234567104',
        ]);
        
        StaffModel::create([
            'user_id' => $user4->user_id,
            'name' => 'Diana Ferianti',
            'nip' => '9001010004', // 10 characters
            'ktp_scan' => 'storage/staff/ktp/9001010004.jpg',
            'photo' => 'storage/staff/photos/9001010004.jpg',
            'home_address' => 'Jl. Arjuno No. 404, Malang',
            'current_address' => 'Jl. Tidar No. 404, Malang',
        ]);

        // STAFF 5
        $user5 = UserModel::create([
            'role' => 'staff',
            'identity_number' => '9001010005',
            'password' => Hash::make('password123'),
            'exam_status' => 'not_yet',
            'phone_number' => '081234567105',
        ]);
        
        StaffModel::create([
            'user_id' => $user5->user_id,
            'name' => 'Eko Prasetyo',
            'nip' => '9001010005', // 10 characters
            'ktp_scan' => 'storage/staff/ktp/9001010005.jpg',
            'photo' => 'storage/staff/photos/9001010005.jpg',
            'home_address' => 'Jl. Diponegoro No. 505, Malang',
            'current_address' => 'Jl. Sudirman No. 505, Malang',
        ]);
    }
}