<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $editingAnnouncement = $request->integer('edit') ? Announcement::findOrFail($request->integer('edit')) : null;

        return view('admin.announcements', [
            'announcements' => Announcement::with('creator')->latest()->get(),
            'editingAnnouncement' => $editingAnnouncement,
        ]);
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Announcement::create([
            'created_by' => auth()->id(),
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'target' => $data['target'],
            'published_at' => now(),
        ]);

        return back()->with('status', 'Pengumuman berhasil dipublikasikan.');
    }

    public function update(StoreAnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $data = $request->validated();

        $announcement->update([
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'target' => $data['target'],
        ]);

        return back()->with('status', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return back()->with('status', 'Pengumuman berhasil dihapus.');
    }
}
