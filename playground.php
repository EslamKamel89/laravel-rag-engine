<?php

use App\Models\KnowledgeBase;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Storage;

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

//
$knowledgeBase = KnowledgeBase::first();
pr($knowledgeBase->chunks);
