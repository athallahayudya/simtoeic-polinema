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
        Schema::table('lecturer', function (Blueprint $table) {
            // Modify nidn to be nullable
            $table->string('nidn', 18)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecturer', function (Blueprint $table) {
            // Revert nidn to be required
            $table->string('nidn', 18)->nullable(false)->change();
        });
    }
};
