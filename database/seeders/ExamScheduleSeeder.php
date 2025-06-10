<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExamScheduleModel;

class ExamScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schedule 1: Morning session
        ExamScheduleModel::firstOrCreate(
            [
                'exam_date' => '2025-06-15',
                'exam_time' => '09:00:00'
            ],
            [
                'itc_link' => 'https://itc-indonesia.com/',
                'zoom_link' => 'https://zoom.us/j/123456789?pwd=abcdef12345',
            ]
        );

        // Schedule 2: Afternoon session
        ExamScheduleModel::firstOrCreate(
            [
                'exam_date' => '2025-06-15',
                'exam_time' => '13:30:00'
            ],
            [
                'itc_link' => 'https://itc-indonesia.com/',
                'zoom_link' => 'https://zoom.us/j/987654321?pwd=fedcba54321',
            ]
        );

        // Schedule 3: Next day morning
        ExamScheduleModel::firstOrCreate(
            [
                'exam_date' => '2025-06-16',
                'exam_time' => '09:00:00'
            ],
            [
                'itc_link' => 'https://itc-indonesia.com/',
                'zoom_link' => 'https://zoom.us/j/111222333?pwd=aaa222bbb333',
            ]
        );

        // Schedule 4: Next day afternoon
        ExamScheduleModel::firstOrCreate(
            [
                'exam_date' => '2025-06-16',
                'exam_time' => '13:30:00'
            ],
            [
                'itc_link' => 'https://itc-indonesia.com/',
                'zoom_link' => 'https://zoom.us/j/444555666?pwd=ddd555eee666',
            ]
        );

        // Schedule 5: Next month
        ExamScheduleModel::firstOrCreate(
            [
                'exam_date' => '2025-07-10',
                'exam_time' => '09:00:00'
            ],
            [
                'itc_link' => 'https://itc-indonesia.com/',
                'zoom_link' => 'https://zoom.us/j/777888999?pwd=ggg888hhh999',
            ]
        );

        // Schedule 6: Weekend session
        ExamScheduleModel::firstOrCreate(
            [
                'exam_date' => '2025-06-21',
                'exam_time' => '10:00:00'
            ],
            [
                'itc_link' => 'https://itc-indonesia.com/',
                'zoom_link' => 'https://zoom.us/j/555666777?pwd=jjj666kkk777',
            ]
        );
    }
}
