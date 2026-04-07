<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // faculty who recommends
            $table->string('title');
            $table->string('author_name');
            $table->string('publisher_name')->nullable();
            $table->year('publication_year')->nullable();
            $table->string('file_type')->nullable();
            $table->text('reason')->nullable();           // why recommending
            $table->string('resource_url')->nullable();   // optional link
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('librarian_note')->nullable();   // librarian's feedback
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};