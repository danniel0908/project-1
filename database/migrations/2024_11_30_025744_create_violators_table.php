<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('violators', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number');
            $table->string('violator_name');
            $table->string('violation_details');
            $table->decimal('fee', 8, 2);
            $table->date('violation_date')->nullable(); // Allow null values
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violators');
    }
};
