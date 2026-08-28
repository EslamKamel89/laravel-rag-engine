<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('knowledge-bases.index'));
//
Route::livewire('/admin/knowledge-base', 'pages::admin.knowledge-base-admin')
    ->name('knowledge-bases.index');
Route::livewire('/admin/knowledge-base/create', 'pages::admin.knowledge-base-create')
    ->name('knowledge-bases.create');
Route::livewire('/admin/knowledge-base/{knowledgeBase}', 'pages::admin.knowledge-base-show')
    ->name('knowledge-bases.show');
