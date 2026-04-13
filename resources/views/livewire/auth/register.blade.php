<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.split')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-[0_16px_40px_-24px_rgba(15,23,42,0.35)] backdrop-blur sm:p-8">
    <div class="mb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">Portal Akademi</p>
        <h1 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">Daftar akun baru</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            Buat akun untuk mengakses dashboard, ikut kelas, dan lihat progress belajar Anda.
        </p>
    </div>

    <x-auth-session-status class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700" :status="session('status')" />

    <form wire:submit="register" class="space-y-5">
        <flux:input
            wire:model="name"
            label="{{ __('Nama Lengkap') }}"
            type="text"
            name="name"
            required
            autofocus
            autocomplete="name"
            placeholder="Nama lengkap"
        />

        <flux:input
            wire:model="email"
            label="{{ __('Alamat Email') }}"
            type="email"
            name="email"
            required
            autocomplete="email"
            placeholder="nama@email.com"
        />

        <flux:input
            wire:model="password"
            label="{{ __('Password') }}"
            type="password"
            name="password"
            required
            autocomplete="new-password"
            placeholder="Buat password"
        />

        <flux:input
            wire:model="password_confirmation"
            label="{{ __('Konfirmasi Password') }}"
            type="password"
            name="password_confirmation"
            required
            autocomplete="new-password"
            placeholder="Ulangi password"
        />

        <flux:button variant="primary" type="submit" class="w-full rounded-xl bg-sky-600 hover:bg-sky-700">
            {{ __('Daftar') }}
        </flux:button>
    </form>

    <div class="mt-6 border-t border-slate-200 pt-4 text-center text-sm text-slate-600">
        Sudah punya akun?
        <x-text-link href="{{ route('login') }}" class="font-semibold text-sky-700 hover:text-sky-800">Masuk sekarang</x-text-link>
    </div>
</div>
