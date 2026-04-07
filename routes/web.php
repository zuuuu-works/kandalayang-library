<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EResourceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FileAccessController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;

// ─── Public Routes ────────────────────────────────────────────────────────────

Route::get('/', fn() => redirect()->route('login'));

// ─── Authentication Module (All roles) ───────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Authenticated Routes ─────────────────────────────────────────────────────

Route::middleware(['auth'])->group(function () {

    // ── Search and Access Module (All roles) ──────────────────────────────────
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search/access/{eResource}', [SearchController::class, 'access'])->name('search.access');

    // ── File Access (All roles) ───────────────────────────────────────────────
    Route::get('/file/access/{eResource}', [FileAccessController::class, 'access'])->name('file.access');

    // ── Dashboards per role ───────────────────────────────────────────────────
    Route::get('/dashboard/librarian',  fn() => view('dashboard.librarian'))->name('librarian.dashboard');
    Route::get('/dashboard/student',    fn() => view('dashboard.student'))->name('student.dashboard');
    Route::get('/dashboard/faculty',    fn() => view('dashboard.faculty'))->name('faculty.dashboard');
    Route::get('/dashboard/researcher', fn() => view('dashboard.researcher'))->name('researcher.dashboard');

    // ── Librarian-only Routes ─────────────────────────────────────────────────
    Route::middleware('role:librarian')->group(function () {

        // E-Resource Management Module
        Route::resource('e-resources', EResourceController::class);
        Route::resource('authors', AuthorController::class)->except(['show']);
        Route::resource('publishers', PublisherController::class)->except(['show']);

        // User Management Module
        Route::get('/users',                     [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{user}',              [UserManagementController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit',         [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',              [UserManagementController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/activate',   [UserManagementController::class, 'activate'])->name('users.activate');
        Route::patch('/users/{user}/deactivate', [UserManagementController::class, 'deactivate'])->name('users.deactivate');

        // Reporting Module
        Route::get('/reports',             [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/access-logs', [ReportController::class, 'accessLogs'])->name('reports.access-logs');
    });
});