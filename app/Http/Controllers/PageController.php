<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Program;
use App\Models\User;
use Illuminate\View\View;

class PageController extends Controller
{
    public function landing(): View
    {
        $stats = [
            'programs' => Program::count(),
            'classes' => Kelas::count(),
            'mentors' => User::where('role', 'mentor')->count(),
            'participants' => User::where('role', 'peserta')->count(),
        ];

        return view('landing', compact('stats'));
    }

    public function home(): View
    {
        return view('home');
    }
}
