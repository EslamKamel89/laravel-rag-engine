<?php

namespace App\Models;

use App\Enums\KnowledgeBaseStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(["title", "original_filename", "file_path", "status", "error_message"])]
class KnowledgeBase extends Model {
    /** @use HasFactory<\Database\Factories\KnowledgeBaseFactory> */
    use HasFactory;

    protected function casts(): array {
        return [
            'status' => KnowledgeBaseStatus::class,
        ];
    }
    public function isGenerating() {
        return $this->status === KnowledgeBaseStatus::GENERATING;
    }
    public function isCompleted() {
        return $this->status === KnowledgeBaseStatus::COMPLETED;
    }
    public function isFailed() {
        return  $this->status === KnowledgeBaseStatus::FAILED;
    }
    public function chunks(): HasMany {
        return $this->hasMany(DocumentChunk::class);
    }
}
