<?php

use App\Enums\KnowledgeBaseStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('knowledge_bases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_filename');
            $table->string('file_path');
            $table->enum('status', array_map(fn(KnowledgeBaseStatus $status) => $status->value, KnowledgeBaseStatus::cases()))
                ->default(KnowledgeBaseStatus::PENDING->value);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('knowledge_bases');
    }
};
