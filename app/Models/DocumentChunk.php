<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pgvector\Laravel\HasNeighbors;
use Pgvector\Laravel\Vector;

#[Fillable(['knowledge_base_id', 'content', 'embedding'])]
class DocumentChunk extends Model {
    /** @use HasFactory<\Database\Factories\DocumentChunkFactory> */
    use HasFactory, HasNeighbors;

    protected function casts(): array {
        return [
            'embedding' => Vector::class,
        ];
    }

    public function knowledgeBase(): BelongsTo {
        return $this->belongsTo(knowledgeBase::class);
    }
}
