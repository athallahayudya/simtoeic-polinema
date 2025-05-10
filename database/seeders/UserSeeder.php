<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin (NIP - 18 digits)
        UserModel::firstOrCreate(
            ['identity_number' => '198506122010011002'],
            [
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567890',
            ]
        );
        
        // Students (NIM - 10-12 digits)
        UserModel::firstOrCreate(
            ['identity_number' => '2022102001'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567891',
            ]
        );
        
        UserModel::firstOrCreate(
            ['identity_number' => '2022102002'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'fail',
                'phone_number' => '081234567892',
            ]
        );
        
        // Lecturer (NIDN - 10 digits)
        UserModel::firstOrCreate(
            ['identity_number' => '0015068702'],
            [
                'role' => 'lecturer',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567893',
            ]
        );
        
        UserModel::firstOrCreate(
            ['identity_number' => '0012087601'],
            [
                'role' => 'lecturer',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567894',
            ]
        );
        
        // Staff (NIP - 18 digits)
        UserModel::firstOrCreate(
            ['identity_number' => '196707182005011002'],
            [
                'role' => 'staff',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567895',
            ]
        );
        
        // Alumni (NIK - 16 digits)
        UserModel::firstOrCreate(
            ['identity_number' => '3525016701880002'],
            [
                'role' => 'alumni',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567896',
            ]
        );
    }
}