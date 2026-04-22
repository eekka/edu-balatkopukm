<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <flux:sidebar sticky stashable class="w-[18rem] sm:w-80 border-r border-blue-950/20 bg-gradient-to-b from-blue-950 via-blue-900 to-sky-900 text-white">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            @php
                $role = auth()->user()->role;

                $roleMeta = [
                    'admin' => [
                        'subtitle' => 'Admin Control Center',
                    ],
                    'mentor' => [
                        'subtitle' => 'Mentor Teaching Panel',
                    ],
                    'peserta' => [
                        'subtitle' => 'Peserta Learning Panel',
                    ],
                ][$role] ?? [
                    'subtitle' => 'Learning Panel',
                    'panel' => 'Akses Aktif',
                    'description' => 'Akses fitur disesuaikan dengan peran akun Anda.',
                    'chips' => ['Dashboard'],
                ];
            @endphp

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-4" wire:navigate>
                <span class="flex size-12 items-center justify-center rounded-none bg-white/15 text-lg font-black tracking-tight ring-1 ring-white/15">
                    L3
                </span>

                <span class="grid min-w-0 leading-tight">
                    <span class="text-xl font-black tracking-tight sm:text-2xl">Akademi <br>
                        <sup class="text-sky-200">Balatkop</sup></span>
                    <span class="text-[0.62rem] uppercase tracking-[0.18em] text-blue-200/80 sm:text-[0.7rem] sm:tracking-[0.24em]">{{ $roleMeta['subtitle'] }}</span>
                </span>
            </a>

            <flux:navlist variant="outline" class="mt-4 px-3">
                <flux:navlist.group heading="Platform" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" class="text-sm" wire:navigate>
                        Dashboard
                    </flux:navlist.item>
                </flux:navlist.group>

                @if (auth()->user()->role === 'admin')
                    <flux:navlist.group heading="Manajemen" class="mt-4 grid">
                        <flux:navlist.item :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" class="text-sm" wire:navigate>
                            Akun
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('admin.programs.index')" :current="request()->routeIs('admin.programs.*')" class="text-sm" wire:navigate>
                            Program
                        </flux:navlist.item>
                        <flux:navlist.item icon="book-open" :href="route('admin.kelas.index')" :current="request()->routeIs('admin.kelas.*')" class="text-sm" wire:navigate>
                            Kelas
                        </flux:navlist.item>
                        <flux:navlist.item icon="megaphone" :href="route('admin.announcements.index')" :current="request()->routeIs('admin.announcements.*')" class="text-sm" wire:navigate>
                            Pengumuman
                        </flux:navlist.item>
                        <flux:navlist.item icon="chat-bubble-bottom-center-text" :href="route('admin.testimonials.index')" :current="request()->routeIs('admin.testimonials.*')" class="text-sm" wire:navigate>
                            Testimoni
                        </flux:navlist.item>
                        <flux:navlist.item icon="chart-bar" :href="route('admin.reports.index')" :current="request()->routeIs('admin.reports.*')" class="text-sm" wire:navigate>
                            Laporan
                        </flux:navlist.item>
                    </flux:navlist.group>
                @elseif (auth()->user()->role === 'mentor')
                    <flux:navlist.group heading="Fitur Mentor" class="mt-4 grid">
                        <flux:navlist.item icon="book-open" :href="route('mentor.kelas.index')" :current="request()->routeIs('mentor.kelas.index')" class="text-sm" wire:navigate>
                            Kelas
                        </flux:navlist.item>
                        <flux:navlist.item icon="megaphone" :href="route('mentor.announcements.index').'#pengumuman'" :current="request()->routeIs('mentor.announcements.index')" class="text-sm" wire:navigate>
                            Pengumuman
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group heading="Akses Cepat" class="mt-4 grid">
                        <flux:navlist.item icon="clipboard-document-list" :href="route('mentor.dashboard').'#akses-cepat'" class="text-sm" wire:navigate>
                            Materi, Tugas, Nilai
                        </flux:navlist.item>
                    </flux:navlist.group>
                @elseif (auth()->user()->role === 'peserta')
                    <flux:navlist.group heading="Fitur Peserta" class="mt-4 grid">
                        <flux:navlist.item icon="book-open" :href="route('peserta.kelas.index').'#kelas-saya'" :current="request()->routeIs('peserta.kelas.index')" class="text-sm" wire:navigate>
                            Kelas
                        </flux:navlist.item>
                        <flux:navlist.item icon="megaphone" :href="route('peserta.announcements.index').'#pengumuman'" :current="request()->routeIs('peserta.announcements.index')" class="text-sm" wire:navigate>
                            Pengumuman
                        </flux:navlist.item>
                        <flux:navlist.item icon="chat-bubble-bottom-center-text" :href="route('peserta.testimonials.index')" :current="request()->routeIs('peserta.testimonials.*')" class="text-sm" wire:navigate>
                            Testimoni
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif

                <flux:navlist.group heading="Akun" class="mt-4 grid">
                    <flux:navlist.item icon="cog" href="{{ route('settings.profile') }}" class="text-sm" wire:navigate>
                        Pengaturan
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <div class="px-4 pb-5">
                <div class="rounded-none bg-white/10 p-4 ring-1 ring-white/10">
                    <div class="flex items-center gap-3">
                        <span class="flex size-11 shrink-0 items-center justify-center rounded-none bg-white/15 text-sm font-bold text-white ring-1 ring-white/15">
                            {{ auth()->user()->initials() }}
                        </span>

                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-blue-200/80">{{ ucfirst(auth()->user()->role) }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button
                            type="submit"
                            class="flex w-full items-center justify-center rounded-none bg-white px-4 py-3 text-sm font-semibold text-blue-700 transition hover:bg-sky-50"
                        >
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </flux:sidebar>

        <flux:header class="border-b border-white/60 bg-white/85 backdrop-blur lg:hidden dark:border-slate-800 dark:bg-slate-950/85">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <div class="ml-3 flex min-w-0 flex-col">
                <span class="truncate text-sm font-semibold text-slate-900 dark:text-white">Akademi Balatkop</span>
                <span class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $roleMeta['subtitle'] }}</span>
            </div>

            <flux:spacer />

            <div class="flex items-center gap-2">
                <span class="flex size-9 items-center justify-center rounded-full bg-blue-600 text-xs font-semibold text-white">
                    {{ auth()->user()->initials() }}
                </span>
            </div>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
