<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.split')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('Tautan reset password akan dikirim jika akun ditemukan.'));
    }
}; ?>

<div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-[0_16px_40px_-24px_rgba(15,23,42,0.35)] backdrop-blur sm:p-8">
    <img src="{asset('')}" alt="">
    <div class="mb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">Portal Akademi</p>
        <h1 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">Lupa Password</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">Masukkan email Anda untuk menerima tautan reset password.</p>
    </div>

    <x-auth-session-status class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-5">
        <flux:input
            class="text-slate-900"
            input:class="border! border-slate-200! text-slate-900 placeholder:text-slate-400"
            wire:model="email"
            label="{{ __('Email Address') }}"
            type="email"
            name="email"
            required
            autofocus
            placeholder="Alamat Email"
        />

        <flux:button variant="primary" type="submit" class="w-full rounded-xl bg-sky-600 hover:bg-sky-700 text-white">
            {{ __('Kirim tautan reset password') }}
        </flux:button>
    </form>

    <div class="mt-6 border-t border-slate-200 pt-4 text-center text-sm text-slate-600">
        Kembali ke
        <x-text-link href="{{ route('login') }}" class="font-semibold text-sky-700! hover:text-sky-800 no-underline!">Masuk</x-text-link>
    </div>
</div>