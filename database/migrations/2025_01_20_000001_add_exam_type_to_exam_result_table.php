<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_result', function (Blueprint $table) {
            // Add exam type column to differentiate between free and paid exams
            $table->enum('exam_type', ['gratis', 'mandiri'])->default('gratis')->after('status');
            
            // Add index for better performance
            $table->index('exam_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_result', function (Blueprint $table) {
            $table->dropIndex(['exam_type']);
            $table->dropColumn('exam_type');
        });
    }
};
