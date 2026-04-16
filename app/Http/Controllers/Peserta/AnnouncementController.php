<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        return view('peserta.announcements.index', [
            'announcements' => Announcement::with('creator')
                ->whereIn('target', ['all', 'peserta'])
                ->latest()
                ->get(),
        ]);
    }
}
