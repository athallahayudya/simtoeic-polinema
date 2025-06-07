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
            // Add new columns for detailed TOEIC scores
            $table->string('exam_id')->nullable()->after('result_id'); // ID exam from PDF
            $table->integer('listening_score')->nullable()->after('score'); // L score
            $table->integer('reading_score')->nullable()->after('listening_score'); // R score
            $table->integer('total_score')->nullable()->after('reading_score'); // TOT score
            $table->date('exam_date')->nullable()->after('total_score'); // Test date
            $table->enum('status', ['pass', 'fail'])->nullable()->after('exam_date'); // Pass/Fail status
            
            // Add index for better performance
            $table->index('exam_id');
            $table->index('status');
            $table->index('exam_date');
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
            $table->dropIndex(['exam_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['exam_date']);
            
            $table->dropColumn([
                'exam_id',
                'listening_score',
                'reading_score',
                'total_score',
                'exam_date',
                'status'
            ]);
        });
    }
};
