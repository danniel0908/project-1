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
        Schema::create('poda_dropping', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('custom_id')->unique()->nullable();

            $table->unsignedBigInteger('user_id')->nullable(); // Define the column as unsignedBigInteger
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add the foreign key constraint
            
            // Separated Applicant's name fields
            $table->string('applicant_first_name')->nullable();
            $table->string('applicant_middle_name')->nullable();
            $table->string('applicant_last_name')->nullable();
            $table->string('applicant_suffix')->nullable();

            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('validity_period')->nullable();
            $table->string('case_no')->nullable(); // Adjusted column name
            $table->string('status')->nullable();

            $table->string('reasons')->nullable(); // Add this line


            $table->timestamps();

            $table->string('remarks')->nullable(); // Add this line

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podadropping');
    }
};
