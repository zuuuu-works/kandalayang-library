<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('e_resources', function (Blueprint $table) {
            $table->id();                                                   // ResourceID
            $table->string('title');                                        // Business Rule #5
            $table->text('description')->nullable();
            $table->string('isbn')->nullable()->unique();                   // Bibliographic detail
            $table->year('publication_year')->nullable();                   // Bibliographic detail
            $table->string('file_url')->nullable();                         // Link or file path to the resource
            $table->string('file_type')->nullable();                        // e.g., PDF, ePub, Video

            // Foreign Keys (Business Rules #1, #2, #3, #4)
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('author_id')->constrained('authors')->restrictOnDelete();
            $table->foreignId('publisher_id')->constrained('publishers')->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('e_resources');
    }
};