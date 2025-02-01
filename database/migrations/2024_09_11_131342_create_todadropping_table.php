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
        Schema::create('toda_dropping', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('custom_id')->unique()->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('applicant_first_name')->nullable();
            $table->string('applicant_middle_name')->nullable();
            $table->string('applicant_last_name')->nullable();
            $table->string('applicant_suffix')->nullable();

            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('validity_period')->nullable();
            $table->string('case_no')->nullable(); 
            $table->string('body_no')->nullable(); 
            $table->string('plate_no')->nullable();
            $table->string('make')->nullable();
            $table->string('engine_no')->nullable(); 
            $table->string('chassis_no')->nullable();

            $table->string('reasons')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->string('remarks')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toda_droppings');
    }
};

