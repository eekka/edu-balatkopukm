<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnnouncementRequest;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $editingAnnouncement = $request->integer('edit')
            ? Announcement::with('targetedUsers')->findOrFail($request->integer('edit'))
            : null;

        return view('admin.announcements', [
            'announcements' => Announcement::with(['creator', 'targetedUsers'])->latest()->get(),
            'editingAnnouncement' => $editingAnnouncement,
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $announcement = Announcement::create([
            'created_by' => auth()->id(),
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'image_path' => $request->file('image')?->store('announcements', 'public'),
            'target' => $data['target'],
            'published_at' => now(),
        ]);

        $this->syncTargetUsers($announcement, $data['user_ids'] ?? []);

        return back()->with('status', 'Pengumuman berhasil dipublikasikan.');
    }

    public function update(StoreAnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $data = $request->validated();

        $imagePath = $announcement->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update([
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'image_path' => $imagePath,
            'target' => $data['target'],
        ]);

        $this->syncTargetUsers($announcement, $data['user_ids'] ?? []);

        return back()->with('status', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        return back()->with('status', 'Pengumuman berhasil dihapus.');
    }

    protected function syncTargetUsers(Announcement $announcement, array $userIds): void
    {
        $announcement->targetedUsers()->sync(
            collect($userIds)
                ->map(fn (mixed $userId): int => (int) $userId)
                ->unique()
                ->values()
                ->all(),
        );
    }
}
