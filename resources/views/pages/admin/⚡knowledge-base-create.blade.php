<?php

use App\Enums\KnowledgeBaseStatus;
use App\Jobs\IndexKnowledgeBaseJob;
use App\Models\KnowledgeBase;
use Livewire\Component;
use livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

new #[Layout('layouts.app')] #[Title('Knowledge Base Create')] class extends Component {
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $title;

    #[Validate('required|file|mimes:pdf,txt|max:10240')]
    public ?TemporaryUploadedFile $documentFile = null;


    public function save() {
        $this->validate();
        $filePath = $this->documentFile->store('knowledge-bases', 'public');
        $knowledgeBase = KnowledgeBase::create([
            'title' => $this->title,
            'original_filename' => $this->documentFile->getClientOriginalName(),
            'file_path' => $filePath,
            'status' => KnowledgeBaseStatus::GENERATING,
        ]);
        IndexKnowledgeBaseJob::dispatch($knowledgeBase);
        $this->redirect(route('admin.knowledge-bases.show', $knowledgeBase), navigate: true);
    }
};
?>

<div class="min-h-full">
    <div class="mx-auto max-w-3xl">

        {{-- Header --}}
        <div class="mb-8">
            <a
                wire:navigate
                href="{{ route('admin.knowledge-bases.index') }}"
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
                <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                    Upload New Document
                </h1>

                <p class="mt-2 max-w-xl text-sm leading-6 text-gray-500 dark:text-gray-400">
                    Add a document to your knowledge base. It will be processed and indexed
                    so your RAG system can use it when answering questions.
                </p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <form wire:submit="save">

                {{-- Form Content --}}
                <div class="space-y-7 p-6 sm:p-8">

                    {{-- Title --}}
                    <div>
                        <label
                            for="title"
                            class="mb-2 block text-sm font-semibold text-gray-900 dark:text-gray-100">
                            Document title
                        </label>

                        <input
                            id="title"
                            wire:model="title"
                            type="text"
                            placeholder="e.g. Company Policy 2025"
                            class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 dark:border-gray-700 dark:bg-gray-950 dark:text-white dark:placeholder:text-gray-600 dark:focus:border-violet-500 dark:focus:ring-violet-500/10" />

                        @error('title')
                        <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- File --}}
                    <div>
                        <label
                            for="documentFile"
                            class="mb-2 block text-sm font-semibold text-gray-900 dark:text-gray-100">
                            Document
                        </label>

                        <label
                            for="documentFile"
                            class="group flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center transition hover:border-violet-400 hover:bg-violet-50/50 dark:border-gray-700 dark:bg-gray-950 dark:hover:border-violet-500 dark:hover:bg-violet-500/5">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-gray-500 shadow-sm ring-1 ring-gray-200 transition group-hover:text-violet-600 dark:bg-gray-900 dark:text-gray-400 dark:ring-gray-800 dark:group-hover:text-violet-400">
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
                                        d="M12 16.5V3.75m0 0L7.5 8.25M12 3.75l4.5 4.5M5.25 15.75v1.5A2.25 2.25 0 0 0 7.5 19.5h9a2.25 2.25 0 0 0 2.25-2.25v-1.5" />
                                </svg>
                            </div>

                            <span class="mt-4 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                Choose a document
                            </span>

                            <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                PDF or TXT files up to 10MB
                            </span>

                            <span class="mt-4 inline-flex items-center rounded-lg bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 transition group-hover:text-violet-600 dark:bg-gray-900 dark:text-gray-300 dark:ring-gray-700 dark:group-hover:text-violet-400">
                                Browse files
                            </span>

                            <input
                                id="documentFile"
                                wire:model="documentFile"
                                type="file"
                                accept=".pdf,.txt"
                                class="sr-only" />
                        </label>

                        @error('documentFile')
                        <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                        @enderror

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">
                            Supported formats: PDF and TXT · Maximum size: 10MB
                        </p>
                    </div>
                    {{-- Selected file --}}
                    @if ($documentFile)
                    <div class="mt-4 rounded-xl border border-violet-200 bg-violet-50 p-4 dark:border-violet-500/20 dark:bg-violet-500/5">
                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-violet-600 shadow-sm dark:bg-gray-900 dark:text-violet-400">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
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

                            <div class="min-w-0">
                                <p class="text-xs font-medium text-violet-600 dark:text-violet-400">
                                    Document selected
                                </p>

                                <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $documentFile->getClientOriginalName() }}
                                </p>
                            </div>

                        </div>
                    </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-end dark:border-gray-800 dark:bg-gray-950/50">

                    <a
                        href="{{ route('admin.knowledge-bases.index') }}"
                        class="inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-gray-600 transition-colors hover:bg-gray-200 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-900/10 disabled:cursor-not-allowed disabled:opacity-60 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 dark:focus:ring-white/10">
                        <svg
                            wire:loading.remove
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-4 w-4">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 16.5V3.75m0 0L7.5 8.25M12 3.75l4.5 4.5M5.25 15.75v1.5A2.25 2.25 0 0 0 7.5 19.5h9a2.25 2.25 0 0 0 2.25-2.25v-1.5" />
                        </svg>

                        <svg
                            wire:loading
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-4 w-4 animate-spin">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3v3m0 12v3m9-9h-3M6 12H3m15.364-6.364-2.121 2.121M8.757 15.243l-2.121 2.121m0-12.728 2.121 2.121m6.486 6.486 2.121 2.121" />
                        </svg>

                        <span wire:loading.remove>
                            Upload & Index
                        </span>

                        <span wire:loading>
                            Uploading & Indexing...
                        </span>
                    </button>

                </div>
            </form>
        </div>

        {{-- Processing Information --}}
        <div class="mt-5 flex gap-3 rounded-xl border border-violet-200 bg-violet-50 p-4 dark:border-violet-500/20 dark:bg-violet-500/5">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="mt-0.5 h-5 w-5 shrink-0 text-violet-600 dark:text-violet-400">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM10.5 3.75h3L21 18.75H3L10.5 3.75Z" />
            </svg>

            <div>
                <p class="text-sm font-semibold text-violet-900 dark:text-violet-200">
                    What happens after upload?
                </p>

                <p class="mt-1 text-xs leading-5 text-violet-700 dark:text-violet-300">
                    Your document is stored and queued for indexing. The indexing process
                    will prepare the document for retrieval by the RAG system.
                </p>
            </div>
        </div>

    </div>
</div>