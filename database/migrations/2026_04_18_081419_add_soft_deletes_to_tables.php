<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add soft deletes to e_resources
        Schema::table('e_resources', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to authors
        Schema::table('authors', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to publishers
        Schema::table('publishers', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('e_resources', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('authors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('publishers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};