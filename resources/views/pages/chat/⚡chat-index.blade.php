<?php

use App\Enums\KnowledgeBaseStatus;
use App\Models\KnowledgeBase;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')]  #[Title('Knowledge Base Assistant')] class extends Component {
    #[Computed]
    public function knowledgeBases() {
        return KnowledgeBase::query()
            ->where('status', KnowledgeBaseStatus::COMPLETED)
            ->latest()
            ->get();
    }
};
?>


<div class="min-h-full">
    <div class="mx-auto max-w-4xl">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                Knowledge Base Assistant
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">
                Select an indexed document to start an AI-powered chat session using
                its knowledge as context.
            </p>
        </div>

        @forelse ($this->knowledgeBases as $knowledgeBase)

        @if ($loop->first)
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @endif

            <div
                wire:key="knowledge-base-{{ $knowledgeBase->id }}"
                class="flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-gray-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700">
                <div>
                    {{-- Document Icon --}}
                    <div class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-5 w-5">
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

                    {{-- Document Information --}}
                    <h2 class="truncate text-lg font-semibold text-gray-950 dark:text-white">
                        {{ $knowledgeBase->title }}
                    </h2>

                    <p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400">
                        {{ $knowledgeBase->original_filename }}
                    </p>

                    {{-- Status --}}
                    <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Ready for questions
                    </div>
                </div>

                {{-- Action --}}
                <div class="mt-6 border-t border-gray-100 pt-5 dark:border-gray-800">
                    <a
                        href="{{ route('chat.interface', $knowledgeBase) }}"
                        wire:navigate
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
                        Chat with document

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
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            @if ($loop->last)
        </div>
        @endif

        @empty

        {{-- Empty State --}}
        <div class="rounded-2xl border-2 border-dashed border-gray-200 bg-white px-6 py-14 text-center dark:border-gray-800 dark:bg-gray-900">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
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

            <h2 class="mt-4 text-sm font-semibold text-gray-900 dark:text-gray-100">
                No documents available
            </h2>

            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-500 dark:text-gray-400">
                No documents have finished indexing yet. Once a document is indexed,
                it will appear here and become available for questions.
            </p>
        </div>

        @endforelse

    </div>
</div>