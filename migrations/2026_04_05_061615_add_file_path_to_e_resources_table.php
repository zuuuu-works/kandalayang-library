<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_resources', function (Blueprint $table) {
            // file_path stores the local storage path
            // file_url stores external links (Google Drive, etc.)
            $table->string('file_path')->nullable()->after('file_url');
        });
    }

    public function down(): void
    {
        Schema::table('e_resources', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};