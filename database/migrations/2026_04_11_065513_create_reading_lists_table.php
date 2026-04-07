<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Reading list (the collection itself)
        Schema::create('reading_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');                        // e.g. "IT 101 Required Reading"
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(true);  // visible to all users
            $table->timestamps();
        });

        // Items inside a reading list
        Schema::create('reading_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reading_list_id')->constrained('reading_lists')->cascadeOnDelete();
            $table->foreignId('e_resource_id')->constrained('e_resources')->cascadeOnDelete();
            $table->integer('order')->default(0);         // ordering of items
            $table->timestamps();

            $table->unique(['reading_list_id', 'e_resource_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reading_list_items');
        Schema::dropIfExists('reading_lists');
    }
};