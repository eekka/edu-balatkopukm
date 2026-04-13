<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mentor\StoreKelasRequest;
use App\Models\Kelas;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KelasController extends Controller
{
    public function index(): View
    {
        return view('mentor.kelas.index', [
            'myClasses' => Kelas::where('mentor_id', auth()->id())
                ->with(['program', 'enrollments'])
                ->latest()
                ->get(),
            'programs' => Program::orderBy('nama')->get(),
        ]);
    }

    public function store(StoreKelasRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Kelas::create([
            'program_id' => $data['program_id'],
            'nama' => $data['nama'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'mentor_id' => auth()->id(),
            'mulai' => $data['mulai'] ?? null,
            'selesai' => $data['selesai'] ?? null,
            'kapasitas' => $data['kapasitas'],
            'peserta_terdaftar' => 0,
            'status' => $data['status'],
        ]);

        return back()->with('status', 'Kelas baru berhasil dibuat.');
    }
}
