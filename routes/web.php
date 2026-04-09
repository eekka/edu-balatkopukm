<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelasController as AdminKelasController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
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
