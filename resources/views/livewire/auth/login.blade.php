<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.split')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-[0_16px_40px_-24px_rgba(15,23,42,0.35)] backdrop-blur sm:p-8">
    <div class="mb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">Portal Akademi</p>
        <h1 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">Masuk ke Akun Anda</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            Gunakan email dan password terdaftar untuk melanjutkan ke dashboard.
        </p>
    </div>

    <x-auth-session-status class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <flux:input
            wire:model="email"
            label="{{ __('Email') }}"
            type="email"
            name="email"
            required
            autofocus
            autocomplete="email"
            placeholder="nama@email.com"
        />

        <div class="relative">
            <flux:input
                wire:model="password"
                label="{{ __('Password') }}"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Masukkan password"
            />

            @if (Route::has('password.request'))
                <x-text-link class="absolute right-0 top-0 text-xs text-sky-700 hover:text-sky-800" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </x-text-link>
            @endif
        </div>

        <div class="flex items-center justify-between gap-3">
            <flux:checkbox wire:model="remember" label="{{ __('Ingat saya') }}" />
            <span class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-medium text-sky-700">Aman & Terenkripsi</span>
        </div>

        <flux:button variant="primary" type="submit" class="w-full rounded-xl bg-sky-600 hover:bg-sky-700">
            {{ __('Masuk') }}
        </flux:button>
    </form>

    <div class="mt-6 border-t border-slate-200 pt-4 text-center text-sm text-slate-600">
        Belum punya akun?
        <x-text-link href="{{ route('register') }}" class="font-semibold text-sky-700 hover:text-sky-800">Daftar sekarang</x-text-link>
    </div>
</div>
