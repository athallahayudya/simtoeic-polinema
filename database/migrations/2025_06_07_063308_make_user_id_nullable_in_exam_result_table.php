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
            // Drop foreign key constraint first
            $table->dropForeign(['user_id']);

            // Make user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Re-add foreign key constraint
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
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
            // Drop foreign key constraint
            $table->dropForeign(['user_id']);

            // Make user_id not nullable
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            // Re-add foreign key constraint
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }
};
