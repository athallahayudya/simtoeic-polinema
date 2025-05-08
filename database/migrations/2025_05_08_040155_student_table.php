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
        Schema::create('student', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('name', 100);
            $table->string('nim', 12)->unique();
            $table->string('study_program', 100);
            $table->string('major', 100);
            $table->enum('campus', ['malang', 'psdku_kediri', 'psdku_lumajang', 'psdku_pamekasan']);
            $table->string('ktp_scan');
            $table->string('ktm_scan');
            $table->string('photo');
            $table->text('home_address');
            $table->text('current_address');
            $table->boolean('is_data_complete')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')->references('user_id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
};
