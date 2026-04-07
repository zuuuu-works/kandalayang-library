<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();                                                          // LogID

            // Foreign Keys (Business Rules #10, #11)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('e_resource_id')->constrained('e_resources')->cascadeOnDelete();

            $table->timestamp('accessed_at');                                      // Business Rule #11: access date & time
            $table->enum('access_type', ['view', 'download', 'stream'])           // Business Rule #11: access type
                  ->default('view');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
