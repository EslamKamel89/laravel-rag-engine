<?php

namespace App\Ai\Agents;

use App\Ai\Tools\LocalVectorSearch;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\ProviderTool;
use Stringable;

class DocumentQA implements Agent,  HasTools {
    use Promptable;
    public function __construct(public int $knowledgeBaseId) {
    }
    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string {
        return <<<'INSTRUCTIONS'
        You are a document Q&A assistant. Answer questions based only on the context provided by your search tool.
        Rules:
        - Only answer based on information found in the tool context.
        - Be concise and direct.
        - If the context does not contain the answer, say "I cannot find that information in the uploaded document."
        INSTRUCTIONS;
    }



    /**
     * Get the tools available to the agent.
     *
     * @return list<Agent|Tool|ProviderTool>
     */
    public function tools(): iterable {
        return [
            new LocalVectorSearch($this->knowledgeBaseId)
        ];
    }
}
