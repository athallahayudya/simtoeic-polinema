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
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('exam_result', 'name')) {
                $table->string('name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('exam_result', 'nim')) {
                $table->string('nim')->nullable()->after('name');
                $table->index('nim');
            }
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
            if (Schema::hasColumn('exam_result', 'nim')) {
                $table->dropIndex(['nim']);
                $table->dropColumn(['name', 'nim']);
            }
        });
    }
};
