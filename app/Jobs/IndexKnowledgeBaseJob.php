<?php

namespace App\Jobs;

use App\Enums\KnowledgeBaseStatus;
use App\Models\KnowledgeBase;
use App\Services\Document\PdfParserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Embeddings;

class IndexKnowledgeBaseJob implements ShouldQueue {
    use Queueable;


    public function __construct(public KnowledgeBase $knowledgeBase) {
    }


    public function handle(PdfParserService $pdfParser): void {
        try {
            $content = $pdfParser->extractText($this->knowledgeBase->storagePath());
            $chunks = chunkText($content);
            $response = Embeddings::for($chunks)
                ->dimensions(1536)
                ->generate(Lab::OpenAI, 'text-embedding-3-small');
            foreach ($chunks as $index => $chunk) {
                $this->knowledgeBase->chunks()->create([
                    'content' => $chunk,
                    'embedding' => $response->embeddings[$index]
                ]);
            }
            $this->knowledgeBase->update(['status' => KnowledgeBaseStatus::COMPLETED, 'error_message' => null]);
        } catch (\Throwable $th) {
            $this->knowledgeBase->update(['status' => KnowledgeBaseStatus::FAILED, 'error_message' => $th->getMessage()]);
            throw $th;
        }
    }
}
