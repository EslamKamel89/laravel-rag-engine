<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('document_chunks', function (Blueprint $table) {
            // DB::statement("CREATE EXTENSION IF NOT EXISTS vector");
            // Schema::ensureVectorExtensionExists();
            $table->id();
            $table->foreignId('knowledge_base_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->vector('embedding', dimensions: 1536);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('document_chunks');
    }
};
