<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelasController as AdminKelasController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Mentor\AnnouncementController as MentorAnnouncementController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Mentor\KelasController as MentorKelasController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Peserta\AnnouncementController as PesertaAnnouncementController;
use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
use App\Http\Controllers\Peserta\TestimonialController as PesertaTestimonialController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [PageController::class, 'landing'])->name('home');

// Dashboard routes with role-based access
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'mentor' => redirect()->route('mentor.dashboard'),
            'peserta' => redirect()->route('peserta.dashboard'),
            default => redirect()->route('home'),
        };
    })->name('dashboard');

    Route::get('/admin/dashboard', AdminDashboardController::class)->name('admin.dashboard')->middleware('role:admin');
    Route::get('/mentor/dashboard', MentorDashboardController::class)->name('mentor.dashboard')->middleware('role:mentor');
    Route::get('/peserta/dashboard', PesertaDashboardController::class)->name('peserta.dashboard')->middleware('role:peserta');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('programs', [AdminProgramController::class, 'index'])->name('programs.index');
        Route::post('programs', [AdminProgramController::class, 'store'])->name('programs.store');
        Route::put('programs/{program}', [AdminProgramController::class, 'update'])->name('programs.update');
        Route::delete('programs/{program}', [AdminProgramController::class, 'destroy'])->name('programs.destroy');

        Route::get('kelas', [AdminKelasController::class, 'index'])->name('kelas.index');
        Route::post('kelas', [AdminKelasController::class, 'store'])->name('kelas.store');
        Route::put('kelas/{kelas}', [AdminKelasController::class, 'update'])->name('kelas.update');
        Route::delete('kelas/{kelas}', [AdminKelasController::class, 'destroy'])->name('kelas.destroy');

        Route::get('announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
        Route::put('announcements/{announcement}', [AdminAnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('announcements/{announcement}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');

        Route::get('testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
        Route::put('testimonials/{testimonial}', [AdminTestimonialController::class, 'update'])->name('testimonials.update');
        Route::delete('testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export/users', [AdminReportController::class, 'exportUsers'])->name('reports.export-users');
        Route::get('reports/export/classes', [AdminReportController::class, 'exportClasses'])->name('reports.export-classes');
    });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified', 'role:mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('kelas', [MentorKelasController::class, 'index'])->name('kelas.index');
    Route::get('kelas/create', [MentorKelasController::class, 'create'])->name('kelas.create');
    Route::get('kelas/{kelas}', [MentorKelasController::class, 'show'])->name('kelas.show');
    Route::post('kelas', [MentorKelasController::class, 'store'])->name('kelas.store');

    Route::get('announcements', [MentorAnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('announcements', [MentorAnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('announcements/{announcement}', [MentorAnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('announcements/{announcement}', [MentorAnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

// Peserta routes
Route::middleware(['auth', 'verified', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('dashboard', PesertaDashboardController::class)->name('dashboard');
    Route::get('kelas', [PesertaDashboardController::class, 'indexKelas'])->name('kelas.index');
    Route::post('kelas/join', [PesertaDashboardController::class, 'joinByCode'])->name('kelas.join');
    Route::get('kelas/{kelas}', [PesertaDashboardController::class, 'showKelas'])->name('kelas.show');
    Route::get('jadwal', [PesertaDashboardController::class, 'jadwal'])->name('jadwal');
    Route::get('sertifikat', [PesertaDashboardController::class, 'sertifikat'])->name('sertifikat');
    Route::get('progress', [PesertaDashboardController::class, 'progress'])->name('progress');
    Route::get('testimonials', [PesertaTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('testimonials', [PesertaTestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('announcements', [PesertaAnnouncementController::class, 'index'])->name('announcements.index');

});
