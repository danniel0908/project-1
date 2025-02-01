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

        

        Schema::create('Service_applications', function (Blueprint $table) {
            $table->id();
            $table->string('custom_id')->unique()->nullable();

            $table->unsignedBigInteger('user_id')->nullable(); // Define the column as unsignedBigInteger
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add the foreign key constraint
            $table->string('Service_name')->nullable();
           
            // Separated Applicant's name fields
            $table->string('applicant_first_name')->nullable();
            $table->string('applicant_middle_name')->nullable();
            $table->string('applicant_last_name')->nullable();
            $table->string('applicant_suffix')->nullable();

            $table->string('Address1')->nullable();
            $table->string('Contact_No_1')->nullable();
            $table->string('Gender')->nullable();

            
            // Separated Driver's name fields
            $table->string('driver_first_name')->nullable();
            $table->string('driver_middle_name')->nullable();
            $table->string('driver_last_name')->nullable();
            $table->string('driver_suffix')->nullable();

            $table->string('Contact_No_2')->nullable();
            $table->string('Address_2')->nullable();
            $table->string('age')->nullable();


            $table->string('Body_no')->nullable(); // Adjusted column name
            $table->string('Plate_no')->nullable(); // Adjusted column name
            $table->string('Make')->nullable();
            $table->string('Engine_no')->nullable(); // Adjusted column name
            $table->string('Chassis_no')->nullable(); // Adjusted column name

            $table->string('Status')->nullable();

            $table->timestamps();

            $table->string('remarks')->nullable(); // Add this line

        });
        
        Schema::create('schedule_of_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_application_id')->constrained('service_applications')->onDelete('cascade');
            $table->string('route_from');
            $table->string('route_to');
            $table->time('am_time_from')->nullable();
            $table->time('am_time_to')->nullable();
            $table->time('pm_time_from')->nullable();
            $table->time('pm_time_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Service_applications');
        Schema::dropIfExists('schedule_of_services');
    }
};

