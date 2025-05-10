<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserModel;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADMIN 1
        $user1 = UserModel::firstOrCreate(
            ['identity_number' => '198506122010'],
            [
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567001',
            ]
        );
        
        AdminModel::firstOrCreate(
            ['user_id' => $user1->user_id],
            [
                'name' => 'Dr. Ahmad Surya',
                'nidn' => '198506122010',  // 12 characters
                'ktp_scan' => 'storage/admin/ktp/198506122010.jpg',
                'photo' => 'storage/admin/photos/198506122010.jpg',
                'home_address' => 'Jl. Soekarno Hatta No. 101, Malang',
                'current_address' => 'Jl. MT. Haryono No. 201, Malang',
            ]
        );

        // ADMIN 2
        $user2 = UserModel::firstOrCreate(
            ['identity_number' => '197605252009'],
            [
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567002',
            ]
        );
        
        AdminModel::firstOrCreate(
            ['user_id' => $user2->user_id],
            [
                'name' => 'Dr. Budi Santoso',
                'nidn' => '197605252009',  // 12 characters
                'ktp_scan' => 'storage/admin/ktp/197605252009.jpg',
                'photo' => 'storage/admin/photos/197605252009.jpg',
                'home_address' => 'Jl. Veteran No. 55, Malang',
                'current_address' => 'Jl. Dieng No. 78, Malang',
            ]
        );

        // ADMIN 3
        $user3 = UserModel::firstOrCreate(
            ['identity_number' => '198812302011'],
            [
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567003',
            ]
        );
        
        AdminModel::firstOrCreate(
            ['user_id' => $user3->user_id],
            [
                'name' => 'Dr. Citra Dewi',
                'nidn' => '198812302011',  // 12 characters
                'ktp_scan' => 'storage/admin/ktp/198812302011.jpg',
                'photo' => 'storage/admin/photos/198812302011.jpg',
                'home_address' => 'Jl. Semeru No. 123, Malang',
                'current_address' => 'Jl. Kawi No. 45, Malang',
            ]
        );

        // ADMIN 4
        $user4 = UserModel::firstOrCreate(
            ['identity_number' => '199003152012'],
            [
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567004',
            ]
        );
        
        AdminModel::firstOrCreate(
            ['user_id' => $user4->user_id],
            [
                'name' => 'Dr. Dani Pratama',
                'nidn' => '199003152012',  // 12 characters
                'ktp_scan' => 'storage/admin/ktp/199003152012.jpg',
                'photo' => 'storage/admin/photos/199003152012.jpg',
                'home_address' => 'Jl. Blimbing No. 90, Malang',
                'current_address' => 'Jl. Jakarta No. 77, Malang',
            ]
        );

        // ADMIN 5
        $user5 = UserModel::firstOrCreate(
            ['identity_number' => '198107202008'],
            [
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567005',
            ]
        );
        
        AdminModel::firstOrCreate(
            ['user_id' => $user5->user_id],
            [
                'name' => 'Dr. Eka Putra',
                'nidn' => '198107202008',  // 12 characters
                'ktp_scan' => 'storage/admin/ktp/198107202008.jpg',
                'photo' => 'storage/admin/photos/198107202008.jpg',
                'home_address' => 'Jl. Bandung No. 15, Malang',
                'current_address' => 'Jl. Tlogomas No. 30, Malang',
            ]
        );
    }
}