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
        Schema::create('ppf_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('custom_id')->unique()->nullable();

            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->string('PPF_Association')->nullable();

            $table->string('applicant_first_name')->nullable();
            $table->string('applicant_middle_name')->nullable();
            $table->string('applicant_last_name')->nullable();
            $table->string('applicant_suffix')->nullable();

            $table->string('Contact_No_1')->nullable();
            $table->string('Address1')->nullable();

            $table->string('driver_first_name')->nullable();
            $table->string('driver_middle_name')->nullable();
            $table->string('driver_last_name')->nullable();
            $table->string('driver_suffix')->nullable();

            $table->string('Contact_No_2')->nullable();
            $table->string('Address_2')->nullable();

            $table->string('Body_no')->nullable(); 
            $table->string('Plate_no')->nullable();
            $table->string('Make')->nullable();
            $table->string('Engine_no')->nullable(); 
            $table->string('Chassis_no')->nullable(); 

            $table->string('Status')->nullable();
            $table->string('remarks')->nullable(); 

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PPF_application');
    }
};
