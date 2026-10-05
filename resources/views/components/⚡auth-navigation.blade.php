<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerate();
        $this->redirect(route('admin.login'), navigate: true);
    }
};
?>

<div>
    @auth
    <button
        type="button"
        wire:click="logout"
        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white">
        Logout
    </button>
    @else
    <a
        href="{{ route('admin.login') }}"
        wire:navigate
        class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
        Login
    </a>
    @endauth
</div>