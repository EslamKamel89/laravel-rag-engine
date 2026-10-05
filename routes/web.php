<?php

use App\Http\Middleware\EnsureIsAdmin;
use App\Models\KnowledgeBase;
use App\Services\Document\PdfParserService;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('chat.index'))->name('home');


Route::prefix('admin')
    ->name('admin.')->group(function () {
        Route::middleware(EnsureIsAdmin::class)
            ->group(function () {
                Route::livewire('/knowledge-base', 'pages::admin.knowledge-base-admin')
                    ->name('knowledge-bases.index');
                Route::livewire('/knowledge-base/create', 'pages::admin.knowledge-base-create')
                    ->name('knowledge-bases.create');
                Route::livewire('/knowledge-base/{knowledgeBase}', 'pages::admin.knowledge-base-show')
                    ->name('knowledge-bases.show');
            });

        Route::livewire('/login', 'pages::admin.admin-login')
            ->name('login');
    });

Route::prefix('chat')->name('chat.')->group(function () {
    Route::livewire('/', 'pages::chat.chat-index')
        ->name('index');
    Route::livewire('/{knowledgeBase}', 'pages::chat.chat-interface')
        ->name('interface');
});

Route::prefix('test')->group(function () {
    Route::get('/extract-text', function () {
        $service = app(PdfParserService::class);
        $knowledgeBase = KnowledgeBase::first();
        if (!$knowledgeBase) {
            return response()->json(['error' => 'No knowledge base found'], 404);
        }
        $path = $knowledgeBase->storagePath();
        $text = $service->extractText($path);
        $chunks = chunkText($text);
        foreach ($chunks as $chunk) {
            dump($chunk);
        }
        // return response()->json(['text' => $text]);
    });
    Route::get('/similarity-search', function () {
        $query = request('query');
        $knowledgeBase = KnowledgeBase::first();
        if (!$knowledgeBase) {
            return response()->json(['error' => 'No knowledge base found'], 404);
        }
        $tool = new \App\Ai\Tools\LocalVectorSearch($knowledgeBase->id);
        $result = $tool->similaritySearch($query);
        return response()->json(['result' => $result]);
    });
});
