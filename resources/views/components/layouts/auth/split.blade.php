<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-50 antialiased">
        <div class="grid min-h-dvh lg:grid-cols-2">
            <aside class="relative hidden overflow-hidden border-r border-sky-100 bg-gradient-to-br from-sky-600 via-blue-700 to-slate-800 px-12 py-14 text-white lg:flex lg:flex-col">
                <div class="absolute -left-12 top-8 h-56 w-56 rounded-full bg-white/15 blur-2xl"></div>
                <div class="absolute bottom-10 right-6 h-44 w-44 rounded-full bg-cyan-300/20 blur-2xl"></div>

                <a href="{{ route('home') }}" class="relative z-10 inline-flex items-center gap-3 text-base font-semibold" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20">
                        <x-app-logo-icon class="h-6 fill-current text-white" />
                    </span>
                    {{ config('app.name', 'Akademi Balatkop') }}
                </a>

                <div class="relative z-10 mt-14 max-w-md space-y-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-100">Learning Management Platform</p>
                    <h2 class="text-4xl font-semibold leading-tight">Bangun kapasitas tim lewat pelatihan yang terstruktur.</h2>
                    <p class="text-sm leading-7 text-sky-100/90">
                        Pantau progres belajar, kelola kelas, dan sampaikan materi dari satu dashboard yang rapi dan profesional.
                    </p>
                </div>

                <div class="relative z-10 mt-auto rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur">
                    <p class="text-sm font-semibold">Satu akun, semua akses penting.</p>
                    <p class="mt-2 text-sm leading-6 text-sky-100/90">Admin, mentor, dan peserta dapat masuk dengan alur yang aman dan cepat.</p>
                </div>
            </aside>

            <main class="flex items-center justify-center px-6 py-12 sm:px-10">
                <div class="w-full max-w-md">
                    <a href="{{ route('home') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-slate-700 lg:hidden" wire:navigate>
                        <x-app-logo-icon class="h-5 fill-current text-sky-700" />
                        {{ config('app.name', 'Akademi Balatkop') }}
                    </a>

                    {{ $slot }}
                </div>
            </main>
        </div>
        @fluxScripts
    </body>
</html>
