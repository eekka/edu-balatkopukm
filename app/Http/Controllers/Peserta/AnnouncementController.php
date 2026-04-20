<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        return view('peserta.announcements.index', [
            'announcements' => Announcement::with('creator')
                ->visibleTo($user)
                ->latest()
                ->get(),
        ]);
    }
}
