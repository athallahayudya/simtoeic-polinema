<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(LecturerSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(AlumniSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ExamScheduleSeeder::class);
        $this->call(ExamResultSeeder::class);
        $this->call(AnnouncementSeeder::class);

    }
}