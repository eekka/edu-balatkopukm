<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKelasRequest;
use App\Http\Requests\Admin\UpdateKelasRequest;
use App\Models\Kelas;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelasController extends Controller
{
    public function index(Request $request): View
    {
        $editingKelas = $request->integer('edit') ? Kelas::with('enrollments')->findOrFail($request->integer('edit')) : null;

        return view('admin.kelas', [
            'kelasList' => Kelas::with(['program', 'mentor', 'enrollments.peserta'])->latest()->get(),
            'programs' => Program::orderBy('nama')->get(),
            'mentors' => User::where('role', 'mentor')->orderBy('name')->get(),
            'pesertas' => User::where('role', 'peserta')->orderBy('name')->get(),
            'editingKelas' => $editingKelas,
        ]);
    }

    public function store(StoreKelasRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $kelas = Kelas::create(collect($data)->except('peserta_ids')->all());

        $this->syncPeserta($kelas, $data['peserta_ids'] ?? []);

        return back()->with('status', 'Kelas berhasil dibuat.');
    }

    public function update(UpdateKelasRequest $request, Kelas $kelas): RedirectResponse
    {
        $data = $request->validated();
        $kelas->update(collect($data)->except('peserta_ids')->all());

        $this->syncPeserta($kelas, $data['peserta_ids'] ?? []);

        return back()->with('status', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas): RedirectResponse
    {
        $kelas->delete();

        return back()->with('status', 'Kelas berhasil dihapus.');
    }

    protected function syncPeserta(Kelas $kelas, array $pesertaIds): void
    {
        $kelas->enrollments()->delete();

        foreach ($pesertaIds as $pesertaId) {
            $kelas->enrollments()->create([
                'peserta_id' => $pesertaId,
                'terdaftar_pada' => now(),
                'status' => 'aktif',
            ]);
        }
    }
}
