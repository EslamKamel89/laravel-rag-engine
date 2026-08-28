<?php

use App\Models\KnowledgeBase;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('knowledge Show')] class extends Component {
    public KnowledgeBase $knowledgeBase;
    public function mount(KnowledgeBase $knowledgeBase) {
        $this->knowledgeBase = $knowledgeBase;
    }
};
?>

<div class="min-h-full">
    <div class="mx-auto max-w-3xl">

        {{-- Header --}}
        <div class="mb-8">
            <a
                wire:navigate
                href="{{ route('knowledge-bases.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition-colors hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>

                Back to Knowledge Base
            </a>

            <div class="mt-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-6 w-6">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 14.25v-7.5A2.25 2.25 0 0 0 17.25 4.5h-6.879a2.25 2.25 0 0 0-1.591.659l-3.621 3.621A2.25 2.25 0 0 0 4.5 10.371v9.379A2.25 2.25 0 0 0 6.75 22.5h10.5a2.25 2.25 0 0 0 2.25-2.25v-6Z" />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5v4.125c0 .621.504 1.125 1.125 1.125H13.5" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                            {{ $knowledgeBase->title }}
                        </h1>

                        <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">
                            {{ $knowledgeBase->original_filename }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="p-6 sm:p-8">

                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Indexing status
                        </p>

                        @if ($knowledgeBase->isGenerating())
                        <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-sm font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                            <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500"></span>
                            Processing
                        </div>
                        @elseif ($knowledgeBase->isCompleted())
                        <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Indexed
                        </div>
                        @elseif ($knowledgeBase->isFailed())
                        <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1.5 text-sm font-semibold text-red-700 dark:bg-red-500/10 dark:text-red-400">
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            Failed
                        </div>
                        @else
                        <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5 text-sm font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                            {{ $knowledgeBase->status }}
                        </div>
                        @endif
                    </div>

                    <div class="text-left sm:text-right">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Uploaded
                        </p>

                        <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $knowledgeBase->created_at->format('Y-m-d') }}
                        </p>
                    </div>

                </div>

                <div class="my-6 border-t border-gray-200 dark:border-gray-800"></div>

                {{-- Status Message --}}
                @if ($knowledgeBase->isGenerating())
                <div class="flex gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-500/20 dark:bg-blue-500/5">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0 animate-pulse text-blue-600 dark:text-blue-400">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6v6l4 2" />
                        <circle
                            cx="12"
                            cy="12"
                            r="9" />
                    </svg>

                    <div>
                        <p class="text-sm font-semibold text-blue-900 dark:text-blue-200">
                            Indexing in progress
                        </p>

                        <p class="mt-1 text-xs leading-5 text-blue-700 dark:text-blue-300">
                            Your document is being processed. Refresh this page in a moment
                            to check the latest status.
                        </p>
                    </div>
                </div>

                @elseif ($knowledgeBase->isCompleted())
                <div class="flex gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-500/20 dark:bg-emerald-500/5">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0 text-emerald-600 dark:text-emerald-400">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m5 12 4 4L19 6" />
                    </svg>

                    <div>
                        <p class="text-sm font-semibold text-emerald-900 dark:text-emerald-200">
                            Document indexed successfully
                        </p>

                        <p class="mt-1 text-xs leading-5 text-emerald-700 dark:text-emerald-300">
                            This document is ready to be used by the RAG system for queries.
                        </p>
                    </div>
                </div>

                @elseif ($knowledgeBase->isFailed())
                <div class="flex gap-3 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-500/20 dark:bg-red-500/5">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0 text-red-600 dark:text-red-400">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM10.5 3.75h3L21 18.75H3L10.5 3.75Z" />
                    </svg>

                    <div>
                        <p class="text-sm font-semibold text-red-900 dark:text-red-200">
                            Indexing failed
                        </p>

                        <p class="mt-1 text-xs leading-5 text-red-700 dark:text-red-300">
                            The document could not be indexed successfully. Try uploading the document again.
                        </p>
                    </div>
                </div>
                @endif

            </div>

            {{-- Document Information --}}
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-5 dark:border-gray-800 dark:bg-gray-950/50">
                <dl class="grid gap-5 sm:grid-cols-2">

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            File name
                        </dt>

                        <dd class="mt-1 truncate text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $knowledgeBase->original_filename }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Status
                        </dt>

                        <dd class="mt-1 text-sm font-medium capitalize text-gray-900 dark:text-gray-100">
                            {{ $knowledgeBase->status }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Created
                        </dt>

                        <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $knowledgeBase->created_at->format('Y-m-d') }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Chunks
                        </dt>

                        <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                            —
                        </dd>
                    </div>

                </dl>
            </div>

        </div>

    </div>
</div>