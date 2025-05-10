<?php

namespace Database\Seeders;

use App\Models\StudentModel;
use App\Models\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // USER 1
        $user1 = UserModel::firstOrCreate(
            ['identity_number' => '2023000001'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567801',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user1->user_id],
            [
                'name' => 'Ahmad Pratama',
                'nim' => '2023000001',
                'study_program' => 'D-IV Teknik Informatika',
                'major' => 'Teknologi Informasi',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2023000001.jpg',
                'ktm_scan' => 'storage/ktm/2023000001.jpg',
                'photo' => 'storage/photos/2023000001.jpg',
                'home_address' => 'Jl. Soekarno Hatta No. 9, Malang',
                'current_address' => 'Jl. Veteran No. 8, Malang',
            ]
        );

        // USER 2
        $user2 = UserModel::firstOrCreate(
            ['identity_number' => '2023000002'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'fail',
                'phone_number' => '081234567802',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user2->user_id],
            [
                'name' => 'Budi Santoso',
                'nim' => '2023000002',
                'study_program' => 'D-III Manajemen Informatika - PSDKU Kediri',
                'major' => 'Teknologi Informasi',
                'campus' => 'psdku_kediri',
                'ktp_scan' => 'storage/ktp/2023000002.jpg',
                'ktm_scan' => 'storage/ktm/2023000002.jpg',
                'photo' => 'storage/photos/2023000002.jpg',
                'home_address' => 'Jl. Jakarta No. 45, Kediri',
                'current_address' => 'Jl. Jakarta No. 45, Kediri',
            ]
        );

        // USER 3
        $user3 = UserModel::firstOrCreate(
            ['identity_number' => '2023000003'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567803',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user3->user_id],
            [
                'name' => 'Citra Dewi',
                'nim' => '2023000003',
                'study_program' => 'D-III Akuntansi - PSDKU Lumajang',
                'major' => 'Akuntansi',
                'campus' => 'psdku_lumajang',
                'ktp_scan' => 'storage/ktp/2023000003.jpg',
                'ktm_scan' => 'storage/ktm/2023000003.jpg',
                'photo' => 'storage/photos/2023000003.jpg',
                'home_address' => 'Jl. Diponegoro No. 23, Lumajang',
                'current_address' => 'Jl. MT. Haryono No. 193, Malang',
            ]
        );

        // USER 4
        $user4 = UserModel::firstOrCreate(
            ['identity_number' => '2023000004'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567804',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user4->user_id],
            [
                'name' => 'Dinda Permata',
                'nim' => '2023000004',
                'study_program' => 'D-IV Akuntansi Manajemen - PSDKU Pamekasan',
                'major' => 'Akuntansi',
                'campus' => 'psdku_pamekasan',
                'ktp_scan' => 'storage/ktp/2023000004.jpg',
                'ktm_scan' => 'storage/ktm/2023000004.jpg',
                'photo' => 'storage/photos/2023000004.jpg',
                'home_address' => 'Jl. Pahlawan No. 17, Pamekasan',
                'current_address' => 'Jl. Pahlawan No. 17, Pamekasan',
            ]
        );

        // USER 5
        $user5 = UserModel::firstOrCreate(
            ['identity_number' => '2023000005'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'fail',
                'phone_number' => '081234567805',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user5->user_id],
            [
                'name' => 'Eko Purnomo',
                'nim' => '2023000005',
                'study_program' => 'D-IV Bahasa Inggris untuk Industri Pariwisata',
                'major' => 'Administrasi Niaga',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2023000005.jpg',
                'ktm_scan' => 'storage/ktm/2023000005.jpg',
                'photo' => 'storage/photos/2023000005.jpg',
                'home_address' => 'Jl. Merdeka No. 33, Malang',
                'current_address' => 'Jl. Bandung No. 12, Malang',
            ]
        );

        // Remove duplicate entry for USER 5
        // StudentModel::create([...]) is removed

        // USER 6
        $user6 = UserModel::firstOrCreate(
            ['identity_number' => '2022000006'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567806',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user6->user_id],
            [
                'name' => 'Faisal Hidayat',
                'nim' => '2022000006',
                'study_program' => 'D-IV Teknik Informatika',
                'major' => 'Teknologi Informasi',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2022000006.jpg',
                'ktm_scan' => 'storage/ktm/2022000006.jpg',
                'photo' => 'storage/photos/2022000006.jpg',
                'home_address' => 'Jl. Surabaya No. 6, Malang',
                'current_address' => 'Jl. Surabaya No. 6, Malang',
            ]
        );

        // USER 7
        $user7 = UserModel::firstOrCreate(
            ['identity_number' => '2022000007'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567807',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user7->user_id],
            [
                'name' => 'Gita Fitriani',
                'nim' => '2022000007',
                'study_program' => 'D-IV Keuangan - PSDKU Kediri',
                'major' => 'Akuntansi',
                'campus' => 'psdku_kediri',
                'ktp_scan' => 'storage/ktp/2022000007.jpg',
                'ktm_scan' => 'storage/ktm/2022000007.jpg',
                'photo' => 'storage/photos/2022000007.jpg',
                'home_address' => 'Jl. Ahmad Yani No. 7, Kediri',
                'current_address' => 'Jl. Jakarta No. 45, Kediri',
            ]
        );

        // USER 8
        $user8 = UserModel::firstOrCreate(
            ['identity_number' => '2021000008'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'fail',
                'phone_number' => '081234567808',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user8->user_id],
            [
                'name' => 'Hendra Gunawan',
                'nim' => '2021000008',
                'study_program' => 'D-III Teknik Kimia',
                'major' => 'Teknik Kimia',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2021000008.jpg',
                'ktm_scan' => 'storage/ktm/2021000008.jpg',
                'photo' => 'storage/photos/2021000008.jpg',
                'home_address' => 'Jl. Veteran No. 8, Malang',
                'current_address' => 'Jl. Soekarno Hatta No. 9, Malang',
            ]
        );

        // USER 9
        $user9 = UserModel::firstOrCreate(
            ['identity_number' => '2021000009'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567809',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user9->user_id],
            [
                'name' => 'Indah Cahyani',
                'nim' => '2021000009',
                'study_program' => 'D-III Administrasi Bisnis',
                'major' => 'Administrasi Niaga',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2021000009.jpg',
                'ktm_scan' => 'storage/ktm/2021000009.jpg',
                'photo' => 'storage/photos/2021000009.jpg',
                'home_address' => 'Jl. Sudirman No. 15, Malang',
                'current_address' => 'Jl. Kawi No. 24, Malang',
            ]
        );

        // USER 10
        $user10 = UserModel::firstOrCreate(
            ['identity_number' => '2021000010'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567810',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user10->user_id],
            [
                'name' => 'Joko Susilo',
                'nim' => '2021000010',
                'study_program' => 'D-IV Teknik Elektronika',
                'major' => 'Teknik Elektro',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2021000010.jpg',
                'ktm_scan' => 'storage/ktm/2021000010.jpg',
                'photo' => 'storage/photos/2021000010.jpg',
                'home_address' => 'Jl. Mawar No. 7, Malang',
                'current_address' => 'Jl. Dieng No. 18, Malang',
            ]
        );

        // USER 11
        $user11 = UserModel::firstOrCreate(
            ['identity_number' => '2022000011'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'fail',
                'phone_number' => '081234567811',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user11->user_id],
            [
                'name' => 'Kartika Sari',
                'nim' => '2022000011',
                'study_program' => 'D-III Teknik Sipil - PSDKU Pamekasan',
                'major' => 'Teknik Sipil',
                'campus' => 'psdku_pamekasan',
                'ktp_scan' => 'storage/ktp/2022000011.jpg',
                'ktm_scan' => 'storage/ktm/2022000011.jpg',
                'photo' => 'storage/photos/2022000011.jpg',
                'home_address' => 'Jl. Pendidikan No. 9, Pamekasan',
                'current_address' => 'Jl. Pendidikan No. 9, Pamekasan',
            ]
        );

        // USER 12
        $user12 = UserModel::firstOrCreate(
            ['identity_number' => '2022000012'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567812',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user12->user_id],
            [
                'name' => 'Lukman Hakim',
                'nim' => '2022000012',
                'study_program' => 'D-II Pengembangan Piranti Lunak Situs',
                'major' => 'Teknologi Informasi',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2022000012.jpg',
                'ktm_scan' => 'storage/ktm/2022000012.jpg',
                'photo' => 'storage/photos/2022000012.jpg',
                'home_address' => 'Jl. Tlogomas No. 33, Malang',
                'current_address' => 'Jl. Sigura-gura No. 5, Malang',
            ]
        );

        // USER 13
        $user13 = UserModel::firstOrCreate(
            ['identity_number' => '2023000013'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567813',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user13->user_id],
            [
                'name' => 'Mira Lestari',
                'nim' => '2023000013',
                'study_program' => 'D-III Keuangan',
                'major' => 'Akuntansi',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2023000013.jpg',
                'ktm_scan' => 'storage/ktm/2023000013.jpg',
                'photo' => 'storage/photos/2023000013.jpg',
                'home_address' => 'Jl. Semeru No. 12, Lumajang',
                'current_address' => 'Jl. Semeru No. 12, Lumajang',
            ]
        );

        // USER 14
        $user14 = UserModel::firstOrCreate(
            ['identity_number' => '2023000014'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567814',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user14->user_id],
            [
                'name' => 'Nadia Putri',
                'nim' => '2023000014',
                'study_program' => 'D-IV Administrasi Bisnis',
                'major' => 'Administrasi Niaga',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2023000014.jpg',
                'ktm_scan' => 'storage/ktm/2023000014.jpg',
                'photo' => 'storage/photos/2023000014.jpg',
                'home_address' => 'Jl. Ijen No. 27, Malang',
                'current_address' => 'Jl. Bendungan Sutami No. 14, Malang',
            ]
        );

        // USER 15
        $user15 = UserModel::firstOrCreate(
            ['identity_number' => '2021000015'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'fail',
                'phone_number' => '081234567815',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user15->user_id],
            [
                'name' => 'Oscar Hermawan',
                'nim' => '2021000015',
                'study_program' => 'D-III Teknik Elektro - PSDKU Kediri',
                'major' => 'Teknik Elektro',
                'campus' => 'psdku_kediri',
                'ktp_scan' => 'storage/ktp/2021000015.jpg',
                'ktm_scan' => 'storage/ktm/2021000015.jpg',
                'photo' => 'storage/photos/2021000015.jpg',
                'home_address' => 'Jl. Brawijaya No. 19, Kediri',
                'current_address' => 'Jl. Brawijaya No. 19, Kediri',
            ]
        );

        // USER 16
        $user16 = UserModel::firstOrCreate(
            ['identity_number' => '2022000016'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567816',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user16->user_id],
            [
                'name' => 'Putri Rahayu',
                'nim' => '2022000016',
                'study_program' => 'D-IV Jaringan Telekomunikasi Digital',
                'major' => 'Teknik Elektro',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2022000016.jpg',
                'ktm_scan' => 'storage/ktm/2022000016.jpg',
                'photo' => 'storage/photos/2022000016.jpg',
                'home_address' => 'Jl. Blimbing No. 8, Malang',
                'current_address' => 'Jl. Candi No. 21, Malang',
            ]
        );

        // USER 17
        $user17 = UserModel::firstOrCreate(
            ['identity_number' => '2023000017'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567817',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user17->user_id],
            [
                'name' => 'Qori Amalia',
                'nim' => '2023000017',
                'study_program' => 'D-III Akuntansi',
                'major' => 'Akuntansi',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2023000017.jpg',
                'ktm_scan' => 'storage/ktm/2023000017.jpg',
                'photo' => 'storage/photos/2023000017.jpg',
                'home_address' => 'Jl. Sumbersari No. 30, Malang',
                'current_address' => 'Jl. Sumbersari No. 30, Malang',
            ]
        );

        // USER 18
        $user18 = UserModel::firstOrCreate(
            ['identity_number' => '2021000018'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'success',
                'phone_number' => '081234567818',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user18->user_id],
            [
                'name' => 'Rizki Ramadhan',
                'nim' => '2021000018',
                'study_program' => 'D-IV Teknik Informatika (Internasional)',
                'major' => 'Teknologi Informasi',
                'campus' => 'malang',
                'ktp_scan' => 'storage/ktp/2021000018.jpg',
                'ktm_scan' => 'storage/ktm/2021000018.jpg',
                'photo' => 'storage/photos/2021000018.jpg',
                'home_address' => 'Jl. Tidar No. 45, Malang',
                'current_address' => 'Jl. Tidar No. 45, Malang',
            ]
        );

        // USER 19
        $user19 = UserModel::firstOrCreate(
            ['identity_number' => '2022000019'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'fail',
                'phone_number' => '081234567819',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user19->user_id],
            [
                'name' => 'Sinta Dewi',
                'nim' => '2022000019',
                'study_program' => 'D-III Manajemen Informatika - PSDKU Pamekasan',
                'major' => 'Teknologi Informasi',
                'campus' => 'psdku_pamekasan',
                'ktp_scan' => 'storage/ktp/2022000019.jpg',
                'ktm_scan' => 'storage/ktm/2022000019.jpg',
                'photo' => 'storage/photos/2022000019.jpg',
                'home_address' => 'Jl. Diponegoro No. 11, Pamekasan',
                'current_address' => 'Jl. Diponegoro No. 11, Pamekasan',
            ]
        );

        // USER 20
        $user20 = UserModel::firstOrCreate(
            ['identity_number' => '2023000020'],
            [
                'role' => 'student',
                'password' => Hash::make('password123'),
                'exam_status' => 'not_yet',
                'phone_number' => '081234567820',
            ]
        );

        StudentModel::firstOrCreate(
            ['user_id' => $user20->user_id],
            [
                'name' => 'Taufik Hidayat',
                'nim' => '2023000020',
                'study_program' => 'D-IV Akuntansi Manajemen - PSDKU Lumajang',
                'major' => 'Akuntansi',
                'campus' => 'psdku_lumajang',
                'ktp_scan' => 'storage/ktp/2023000020.jpg',
                'ktm_scan' => 'storage/ktm/2023000020.jpg',
                'photo' => 'storage/photos/2023000020.jpg',
                'home_address' => 'Jl. Kartini No. 5, Lumajang',
                'current_address' => 'Jl. Kartini No. 5, Lumajang',
            ]
        );
    }
}