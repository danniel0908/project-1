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
        Schema::create('poda_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('drive_link')->nullable();
            $table->unsignedBigInteger('poda_application_id'); // Add this to reference TODAapplication
            $table->string('requirement_type')->nullable(); // To store the type of requirement (e.g., "voter_id", "registration_form")
            $table->timestamp('approved_at')->nullable(); 
            $table->string('approved_by')->nullable();
            $table->timestamps();

            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
            $table->foreign('poda_application_id')->references('id')->on('PODAapplication')->onDelete('cascade');
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poda_requirements');
    }
};
