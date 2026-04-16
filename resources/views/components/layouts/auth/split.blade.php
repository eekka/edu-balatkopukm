<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-50 antialiased">
        <div class="grid min-h-dvh lg:grid-cols-2">
            
            <main class="flex items-center justify-center px-6 sm:px-10">
                <div class="w-full max-w-md">
                    <a href="{{ route('home') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-slate-700 lg:hidden" wire:navigate>
                        <x-app-logo-icon class="h-5 fill-current text-sky-700" />
                        {{ config('app.name', 'Akademi Balatkop') }}
                    </a>
                    
                    {{ $slot }}
                </div>
            </main>
            <aside class="relative hidden overflow-hidden border-r border-sky-100 bg-gradient-to-br from-sky-600 via-blue-700 to-slate-800 px-12 py-14 text-white lg:flex lg:flex-col">
                <div class="absolute -left-12 top-8 h-56 w-56 rounded-full bg-white/15 blur-2xl"></div>
                <div class="absolute bottom-10 right-6 h-44 w-44 rounded-full bg-cyan-300/20 blur-2xl"></div>

                <a href="{{ route('home') }}" class="relative z-10 inline-flex items-center gap-3 text-base font-semibold" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20">
                        <x-app-logo-icon class="h-6 fill-current text-white" />
                    </span>
                    {{ config('app.name', 'Akademi Balatkop') }}
                </a>

                <div class="relative z-10 mt-4  max-w-md space-y-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-100">Learning Management Platform</p>
                </div>
                <div class="relative mt-16 flex h-[22rem] flex-col items-center justify-center md:gap-2 md:px-4">
                    <img src="/asset/aball.png" alt="Karakter Belajar" class="w-auto h-auto max-w-sm md:max-w-md">
                </div>
                <div class="relative z-10 mt-6 items-center">
                    <h2 class="text-4xl font-semibold text-center">Bangun kapasitas tim lewat pelatihan yang terstruktur.</h2>
                </div>

            </aside>
        </div>
        @fluxScripts
    </body>
            </html>
