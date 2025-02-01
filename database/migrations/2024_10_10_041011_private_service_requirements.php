<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('private_service_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('drive_link')->nullable();
            $table->unsignedBigInteger('private_service_id');
            $table->string('requirement_type'); // To store the type of requirement (e.g., "voter_id", "registration_form")
            $table->timestamp('approved_at')->nullable(); 
            $table->string('approved_by')->nullable();
            $table->timestamps();

            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
            $table->foreign('private_service_id')->references('id')->on('Service_applications')->onDelete('cascade');
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_service_requirements');
    }
};
