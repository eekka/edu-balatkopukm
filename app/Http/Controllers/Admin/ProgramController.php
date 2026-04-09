<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProgramRequest;
use App\Http\Requests\Admin\UpdateProgramRequest;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(Request $request): View
    {
        $editingProgram = $request->integer('edit') ? Program::findOrFail($request->integer('edit')) : null;

        return view('admin.programs', [
            'programs' => Program::withCount('kelas')->latest()->get(),
            'editingProgram' => $editingProgram,
        ]);
    }

    public function store(StoreProgramRequest $request): RedirectResponse
    {
        Program::create($request->validated());

        return back()->with('status', 'Program berhasil ditambahkan.');
    }

    public function update(UpdateProgramRequest $request, Program $program): RedirectResponse
    {
        $program->update($request->validated());

        return back()->with('status', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return back()->with('status', 'Program berhasil dihapus.');
    }
}
