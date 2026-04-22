<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mentor\StoreDiskusiRequest;
use App\Http\Requests\Mentor\StoreKelasRequest;
use App\Http\Requests\Mentor\StoreMateriRequest;
use App\Http\Requests\Mentor\StoreQuizRequest;
use App\Http\Requests\Mentor\StoreTugasRequest;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Program;
use App\Models\Quiz;
use App\Models\Tugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
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
        ]);
    }

    public function create(): View
    {
        return view('mentor.kelas.create-kelas', [
            'myClasses' => Kelas::where('mentor_id', auth()->id())
                ->with(['program', 'enrollments'])
                ->latest()
                ->get(),
            'programs' => Program::orderBy('nama')->get(),
        ]);
    }

    public function show(Kelas $kelas): View
    {
        abort_unless(auth()->id() === $kelas->mentor_id, 403);

        return view('mentor.kelas.show', [
            'kelas' => $kelas->load([
                'program',
                'enrollments.peserta',
                'materis' => fn ($query) => $query->latest(),
                'tugas' => fn ($query) => $query->latest(),
                'quizzes' => fn ($query) => $query->latest(),
            ]),
        ]);
    }

    public function storeMateri(StoreMateriRequest $request, Kelas $kelas): RedirectResponse
    {
        abort_unless(auth()->id() === $kelas->mentor_id, 403);

        $filePath = $request->file('file')?->store('materi-files', 'public');

        Materi::create([
            'kelas_id' => $kelas->id,
            'judul' => $request->validated('judul'),
            'isi' => $request->validated('isi'),
            'pertemuan' => $request->validated('pertemuan'),
            'tipe' => $request->validated('tipe'),
            'file' => $filePath,
            'url' => $request->validated('url'),
            'urutan' => (int) Materi::where('kelas_id', $kelas->id)->max('urutan') + 1,
        ]);

        return back()->with('status', 'Materi baru berhasil ditambahkan. Peserta dapat melihatnya secara langsung.');
    }

    public function storeTugas(StoreTugasRequest $request, Kelas $kelas): RedirectResponse
    {
        abort_unless(auth()->id() === $kelas->mentor_id, 403);

        Tugas::create([
            'kelas_id' => $kelas->id,
            'judul' => $request->validated('judul'),
            'deskripsi' => $request->validated('deskripsi'),
            'deadline' => $request->validated('deadline'),
            'nilai_maksimal' => $request->validated('nilai_maksimal'),
            'status' => $request->validated('status'),
        ]);

        return back()->with('status', 'Tugas baru berhasil ditambahkan. Peserta dapat mengaksesnya sekarang.');
    }

    public function storeQuiz(StoreQuizRequest $request, Kelas $kelas): RedirectResponse
    {
        abort_unless(auth()->id() === $kelas->mentor_id, 403);

        Quiz::create([
            'kelas_id' => $kelas->id,
            'judul' => $request->validated('judul'),
            'deskripsi' => $request->validated('deskripsi'),
            'waktu_pengerjaan' => $request->validated('waktu_pengerjaan'),
            'nilai_maksimal' => $request->validated('nilai_maksimal'),
            'mulai' => $request->validated('mulai'),
            'selesai' => $request->validated('selesai'),
            'status' => $request->validated('status'),
            'random_soal' => false,
            'auto_grade' => true,
        ]);

        return back()->with('status', 'Quiz baru berhasil ditambahkan. Peserta dapat melihat jadwal quiz secara real-time.');
    }

    public function storeDiskusi(StoreDiskusiRequest $request, Kelas $kelas): RedirectResponse
    {
        abort_unless(auth()->id() === $kelas->mentor_id, 403);

        Materi::create([
            'kelas_id' => $kelas->id,
            'judul' => 'Diskusi: '.Str::title($request->validated('topik')),
            'isi' => $request->validated('isi'),
            'pertemuan' => $request->validated('pertemuan'),
            'tipe' => 'artikel',
            'url' => null,
            'urutan' => (int) Materi::where('kelas_id', $kelas->id)->max('urutan') + 1,
        ]);

        return back()->with('status', 'Topik diskusi berhasil dipublikasikan dan langsung terlihat oleh peserta kelas.');
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
