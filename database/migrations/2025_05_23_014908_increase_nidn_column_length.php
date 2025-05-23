<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class IncreaseNidnColumnLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use raw SQL instead of Schema Builder + DBAL
        DB::statement('ALTER TABLE admin MODIFY nidn VARCHAR(50)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert changes if needed
        DB::statement('ALTER TABLE admin MODIFY nidn VARCHAR(12)');
    }
}