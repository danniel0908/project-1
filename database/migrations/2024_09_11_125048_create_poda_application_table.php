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
        Schema::create('poda_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('custom_id')->unique()->nullable();

            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->string('PODA_Association')->nullable();

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
            $table->string('Sticker_no')->nullable();

            $table->string('Unit_no1')->nullable();
            $table->string('Unit_no2')->nullable(); 
            $table->string('Unit_no3')->nullable();
            $table->string('Unit_no4')->nullable(); 
            $table->string('Unit_no5')->nullable(); 
            $table->string('Unit_no6')->nullable();
            $table->string('Unit_no7')->nullable();
            $table->string('Unit_no8')->nullable();
            $table->string('Unit_no9')->nullable();
            $table->string('Unit_no10')->nullable();
            $table->string('Unit_no11')->nullable();
            $table->string('Unit_no12')->nullable();

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
        Schema::dropIfExists('PODA_application');
    }
};
