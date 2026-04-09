<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Admin</p>
                <h1 class="text-3xl font-bold text-slate-900">Manajemen Akun</h1>
                <p class="mt-2 text-slate-600">Tambah mentor, tambah peserta, edit, hapus, dan reset password.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">
                Kembali ke Dashboard
            </a>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-[1.2fr_1fr]">
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $editingUser ? 'Edit Akun' : 'Tambah Akun' }}</h2>
                        <p class="text-sm text-slate-500">Semua field wajib diisi kecuali yang opsional.</p>
                    </div>
                    @if ($editingUser)
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Batal edit</a>
                    @endif
                </div>

                <form method="POST" action="{{ $editingUser ? route('admin.users.update', $editingUser) : route('admin.users.store') }}" class="grid gap-4 md:grid-cols-2">
                    @csrf
                    @if ($editingUser)
                        @method('PUT')
                    @endif

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Nama</span>
                        <input name="name" value="{{ old('name', $editingUser?->name) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Email</span>
                        <input type="email" name="email" value="{{ old('email', $editingUser?->email) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Username</span>
                        <input name="username" value="{{ old('username', $editingUser?->username) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Role</span>
                        <select name="role" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500" required>
                            @foreach (['admin' => 'Admin', 'mentor' => 'Mentor', 'peserta' => 'Peserta'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('role', $editingUser?->role) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Password {{ $editingUser ? '(kosongkan jika tidak diubah)' : '' }}</span>
                        <input type="password" name="password" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" {{ $editingUser ? '' : 'required' }}>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Instansi</span>
                        <input name="instansi" value="{{ old('instansi', $editingUser?->instansi) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500">
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">No HP</span>
                        <input name="no_hp" value="{{ old('no_hp', $editingUser?->no_hp) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500">
                    </label>

                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Foto Profil</span>
                        <input name="foto_profil" value="{{ old('foto_profil', $editingUser?->foto_profil) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" placeholder="URL foto atau path file">
                    </label>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-2">
                        <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">{{ $editingUser ? 'Update Akun' : 'Simpan Akun' }}</button>
                    </div>
                </form>

                @if ($editingUser)
                    <form method="POST" action="{{ route('admin.users.reset-password', $editingUser) }}" class="mt-4 flex justify-end">
                        @csrf
                        <button type="submit" class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 hover:bg-amber-100">Reset Password</button>
                    </form>
                @endif
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <h2 class="text-xl font-semibold text-slate-900">Import Peserta via Excel</h2>
                <p class="mt-2 text-sm text-slate-500">Fitur ini opsional. Saat ini bisa disiapkan sebagai CSV/Excel upload di tahap berikutnya.</p>
                <div class="mt-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-600">
                    Siapkan template berisi: Nama, Email, Username, Password, Role, Instansi, No HP, Foto Profil.
                </div>
                <div class="mt-6 grid grid-cols-3 gap-3 text-center text-sm font-semibold text-slate-700">
                    <div class="rounded-xl bg-blue-50 p-3">Mentor</div>
                    <div class="rounded-xl bg-emerald-50 p-3">Peserta</div>
                    <div class="rounded-xl bg-slate-100 p-3">Admin</div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Daftar Akun</h2>
                <span class="text-sm text-slate-500">{{ $users->count() }} akun</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Instansi</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->username }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ ucfirst($user->role) }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->instansi ?: '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.users.index', ['edit' => $user->id]) }}" class="rounded-lg border border-blue-200 px-3 py-1.5 text-sm font-semibold text-blue-700 hover:bg-blue-50">Edit</a>
                                        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}">
                                            @csrf
                                            <button type="submit" class="rounded-lg border border-amber-200 px-3 py-1.5 text-sm font-semibold text-amber-700 hover:bg-amber-50">Reset</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>