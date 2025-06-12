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
        Schema::table('verification_requests', function (Blueprint $table) {
            $table->string('certificate_file_2')->nullable()->after('certificate_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verification_requests', function (Blueprint $table) {
            $table->dropColumn('certificate_file_2');
        });
    }
};
