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
            ['title' => 'Welcome to the New Examination System'],
            [
                'content' => 'We are pleased to announce the launch of our new examination management system. Please log in to your account to explore all features.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->format('Y-m-d')
            ]
        );

        // Announcement 2
        AnnouncementModel::firstOrCreate(
            ['title' => 'System Maintenance Notice'],
            [
                'content' => 'The system will undergo maintenance this coming weekend. Please anticipate service disruptions between Saturday 10:00 PM and Sunday 2:00 AM.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->addDays(3)->format('Y-m-d')
            ]
        );

        // Announcement 3
        AnnouncementModel::firstOrCreate(
            ['title' => 'Upcoming Exam Schedule'],
            [
                'content' => 'The schedule for the next round of examinations has been published. Please check the exam schedule section for details.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->subDays(2)->format('Y-m-d')
            ]
        );

        // Announcement 4
        AnnouncementModel::firstOrCreate(
            ['title' => 'New Feature: Certificate Download'],
            [
                'content' => 'We have added a new feature that allows students to download their certificates directly from their profile. This feature will be available starting next week.',
                'announcement_status' => 'draft',
                'announcement_date' => Carbon::now()->addDays(7)->format('Y-m-d')
            ]
        );

        // Announcement 5
        AnnouncementModel::firstOrCreate(
            ['title' => 'Holiday Schedule'],
            [
                'content' => 'The office will be closed during the national holidays from May 1st to May 5th. Online services will remain operational.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->addDays(10)->format('Y-m-d')
            ]
        );

        // Announcement 6 - Recent Draft
        AnnouncementModel::firstOrCreate(
            ['title' => 'Campus Facilities Update'],
            [
                'content' => 'Several campus facilities including the computer laboratory and library will be renovated next month. Alternative arrangements will be announced soon.',
                'announcement_status' => 'draft',
                'announcement_date' => Carbon::now()->addDays(14)->format('Y-m-d')
            ]
        );

        // Announcement 7 - Old Published
        AnnouncementModel::firstOrCreate(
            ['title' => 'Previous Exam Results'],
            [
                'content' => 'Results for the previous exam cycle have been published. Students can view their results in the dashboard.',
                'announcement_status' => 'published',
                'announcement_date' => Carbon::now()->subDays(30)->format('Y-m-d')
            ]
        );
    }
}