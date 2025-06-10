<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add 'on_process' to the exam_status enum
        DB::statement("ALTER TABLE users MODIFY COLUMN exam_status ENUM('success', 'fail', 'not_yet', 'on_process') DEFAULT 'not_yet'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove 'on_process' from the exam_status enum
        // First update any 'on_process' records to 'not_yet'
        DB::statement("UPDATE users SET exam_status = 'not_yet' WHERE exam_status = 'on_process'");
        // Then modify the enum to remove 'on_process'
        DB::statement("ALTER TABLE users MODIFY COLUMN exam_status ENUM('success', 'fail', 'not_yet') DEFAULT 'not_yet'");
    }
};
