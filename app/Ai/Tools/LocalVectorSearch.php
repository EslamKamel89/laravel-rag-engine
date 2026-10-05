<?php

namespace App\Ai\Tools;

use App\Models\DocumentChunk;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Embeddings;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Tools\Request;
use Stringable;

class LocalVectorSearch implements Tool {

    public function __construct(public int $knowledgeBaseId) {
    }
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string {
        return 'Search the uploaded document for relevant information matching the query.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string {
        return $this->similaritySearch($request['query']);
    }

    public function similaritySearch(string $query, float $minSimilarity = 0.3): string {
        $t = 'LocalVectorSearch - similaritySearch';
        pr('handle method is called', $t);
        $query = pr($query, $t . ' - query');
        pr($minSimilarity, $t . ' - minSimilarity');
        $queryEmbeddings = Embeddings::for([$query])
            ->dimensions(1536)
            ->generate(Lab::OpenAI, 'text-embedding-3-small')
            ->embeddings[0];
        pr(count($queryEmbeddings), $t . ' - queryEmbeddings length');
        $chunks = DocumentChunk::query()
            ->where('knowledge_base_id', $this->knowledgeBaseId)
            ->whereVectorSimilarTo('embedding', $queryEmbeddings, minSimilarity: $minSimilarity, order: true)
            ->limit(5)
            ->get();
        if ($chunks->isEmpty()) {
            return pr('No matching context found in the document.', $t . ' - no match');
        }
        return pr($chunks->pluck('content')->join("\n"), $t . ' - result');
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array {
        return [
            'query' => $schema->string()->required(),
        ];
    }
}
