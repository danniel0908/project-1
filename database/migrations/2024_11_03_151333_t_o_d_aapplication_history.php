
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('TODAapplicationHistory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('toda_application_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('new_status')->nullable();
            $table->string('action')->nullable();
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            $table->text('remarks')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('toda_application_id')
                ->references('id')
                ->on('TODAapplication')
                ->onDelete('cascade');
            $table->foreign('admin_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            // Indexes
            $table->index(['toda_application_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TODAapplicationHistory');
    }
};
