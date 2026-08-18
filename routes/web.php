<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('knowledge-bases.index'));
//
Route::livewire('/admin/knowledge-base', 'pages::admin.knowledge-base-admin')
    ->name('knowledge-bases.index');
Route::get('/admin/knowledge-base/create', fn() => 'Not implemented yet')
    ->name('knowledge-bases.create');
Route::get(
    '/admin/knowledge-base/{knowledgeBase}',
    fn() => 'Not implemented yet'
)->name('knowledge-bases.show');
