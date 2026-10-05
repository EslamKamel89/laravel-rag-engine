<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 min-h-screen font-sans antialiased">
    <header class="border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <a
                href="{{ route('chat.index') }}"
                wire:navigate
                class="text-lg font-semibold tracking-tight">
                Rag Bot
            </a>

            <nav class="flex items-center gap-2">
                <a
                    href="{{ route('chat.index') }}"
                    wire:navigate
                    @class([ 'rounded-lg px-3 py-2 text-sm font-medium transition-colors' , 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'=> request()->routeIs('chat.*'),
                    'text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' => ! request()->routeIs('chat.*'),
                    ])>
                    Chat
                </a>

                @if (auth()->user()?->is_admin)
                <a
                    href="{{ route('admin.knowledge-bases.index') }}"
                    wire:navigate
                    @class([ 'rounded-lg px-3 py-2 text-sm font-medium transition-colors' , 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'=> request()->routeIs('admin.knowledge-bases.*'),
                    'text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' => ! request()->routeIs('admin.knowledge-bases.*'),
                    ])>
                    Dashboard
                </a>
                @endif

                <a
                    href="https://github.com/laravel/ai"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white">
                    Docs
                </a>

                <livewire:auth-navigation />
            </nav>
        </div>
    </header>
    <main class="mx-auto max-w-5xl px-6 py-10">
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>