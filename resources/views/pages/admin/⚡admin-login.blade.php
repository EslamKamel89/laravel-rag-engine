<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Interactive\Input\WordNavigationPolicy;

new #[Layout('layouts.app')] #[Title('Admin Login')] class extends Component {
    #[Validate('email|required')]
    public string $email = '';
    #[Validate('required|string|min:6')]
    public string $password = '';

    public function mount() {
        if (auth()->check() && auth()->user()->is_admin) {
            $this->redirect(route('admin.knowledge-bases.index'), navigate: true);
        }
    }
    public function login() {
        $this->validate();
        $authenticated = Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ]);
        if (!$authenticated) {
            session()->flash('error', 'Invalid email or password.');
            return;
        }
        if (auth()->user()->is_admin === false) {
            session()->flash('error', 'You are not authorized to access the admin panel.');
            return;
        }
        session()->regenerate();
        $this->redirect(route('admin.knowledge-bases.index'), navigate: true);
    }
};
?>

<div class="flex min-h-[70vh] items-center justify-center">
    <div class="w-full max-w-md">
        <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-8">
                <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                    Admin Login
                </h1>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Sign in to manage the knowledge base.
                </p>
            </div>

            @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400">
                {{ session('error') }}
            </div>
            @endif

            <form wire:submit="login" class="space-y-6">
                <div>
                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-gray-100">
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        wire:model="email"
                        autocomplete="email"
                        placeholder="admin@example.com"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 dark:border-gray-700 dark:bg-gray-950 dark:text-white dark:placeholder:text-gray-600">

                    @error('email')
                    <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-gray-100">
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        wire:model="password"
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 dark:border-gray-700 dark:bg-gray-950 dark:text-white dark:placeholder:text-gray-600">

                    @error('password')
                    <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="login"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-60 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
                    <span wire:loading.remove wire:target="login">
                        Sign in
                    </span>

                    <span wire:loading wire:target="login">
                        Signing in...
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>