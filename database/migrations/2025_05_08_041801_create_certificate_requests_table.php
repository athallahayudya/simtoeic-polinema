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
        Schema::create('verification_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comment'); // Student's comment/reason for request
            $table->string('certificate_file'); // Path to uploaded certificate
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable(); // Admin's notes/reason for approval/rejection
            $table->unsignedBigInteger('approved_by')->nullable(); // Admin who approved/rejected
            $table->timestamp('approved_at')->nullable();
            $table->string('generated_certificate_path')->nullable(); // Path to generated PDF
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('user_id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('status');
            $table->index('user_id');
            $table->index('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_requests');
    }
};
