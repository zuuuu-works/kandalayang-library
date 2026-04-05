<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                                          // UserID
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();                                     // Business Rule #7: unique email
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['librarian', 'student', 'faculty', 'researcher']); // Business Rule #8
            $table->enum('status', ['active', 'inactive'])->default('active');    // Business Rule #9
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};