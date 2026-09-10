<?php

use App\Models\KnowledgeBase;
use App\Services\Document\PHPParserService;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('knowledge-bases.index'));
//
Route::livewire('/admin/knowledge-base', 'pages::admin.knowledge-base-admin')
    ->name('knowledge-bases.index');
Route::livewire('/admin/knowledge-base/create', 'pages::admin.knowledge-base-create')
    ->name('knowledge-bases.create');
Route::livewire('/admin/knowledge-base/{knowledgeBase}', 'pages::admin.knowledge-base-show')
    ->name('knowledge-bases.show');

Route::prefix('test')->group(function () {
    Route::get('/extract-text', function () {
        $service = app(PHPParserService::class);
        $knowledgeBase = KnowledgeBase::first();
        if (!$knowledgeBase) {
            return response()->json(['error' => 'No knowledge base found'], 404);
        }
        $path = storage_path('/app/public/' . $knowledgeBase->file_path);
        $text = $service->extractText($path);
        return response()->json(['text' => $text]);
    });
});
