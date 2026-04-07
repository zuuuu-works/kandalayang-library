<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EResourceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FileAccessController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CitationController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ResourceRequestController;
use App\Http\Controllers\HistoryController;

// ─────────────────────────────────────────────────────────────
// PUBLIC ROUTES
// ─────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));


// ─────────────────────────────────────────────────────────────
// AUTHENTICATION MODULE
// ─────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ─────────────────────────────────────────────────────────────
// AUTHENTICATED ROUTES
// ─────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // ─── DASHBOARDS ───────────────────────────────────────────
    Route::get('/dashboard/librarian',  fn() => view('dashboard.librarian'))->name('librarian.dashboard');
    Route::get('/dashboard/student',    fn() => view('dashboard.student'))->name('student.dashboard');
    Route::get('/dashboard/faculty',    fn() => view('dashboard.faculty'))->name('faculty.dashboard');
    Route::get('/dashboard/researcher', fn() => view('dashboard.researcher'))->name('researcher.dashboard');

    // ─── SEARCH & ACCESS MODULE ───────────────────────────────
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search/access/{eResource}', [SearchController::class, 'access'])->name('search.access');
    Route::get('/file/access/{eResource}', [FileAccessController::class, 'access'])->name('file.access');

    // ─── BOOKMARKS (ALL USERS) ────────────────────────────────
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/toggle/{eResource}', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    // ─── READING HISTORY (ALL USERS) ─────────────────────────
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    // ─── CITATIONS (ALL USERS) ───────────────────────────────
    Route::get('/citations/{eResource}', [CitationController::class, 'show'])->name('citations.show');

    // ─── RECOMMENDATIONS ──────────────────────────────────────
    Route::get('/recommendations',        [RecommendationController::class, 'index'])->name('recommendations.index');
    Route::get('/recommendations/create', [RecommendationController::class, 'create'])->name('recommendations.create');
    Route::post('/recommendations',       [RecommendationController::class, 'store'])->name('recommendations.store');

    // ─── RESOURCE REQUESTS ───────────────────────────────────
    Route::get('/resource-requests',        [ResourceRequestController::class, 'index'])->name('resource-requests.index');
    Route::get('/resource-requests/create', [ResourceRequestController::class, 'create'])->name('resource-requests.create');
    Route::post('/resource-requests',       [ResourceRequestController::class, 'store'])->name('resource-requests.store');


    // ─────────────────────────────────────────────────────────
    // LIBRARIAN ONLY ROUTES
    // ─────────────────────────────────────────────────────────
    Route::middleware('role:librarian')->group(function () {

        // ─── E-RESOURCE MANAGEMENT ────────────────────────────
        Route::resource('e-resources', EResourceController::class);
        Route::resource('authors', AuthorController::class)->except(['show']);
        Route::resource('publishers', PublisherController::class)->except(['show']);

        // ─── USER MANAGEMENT ──────────────────────────────────
        Route::get('/users',                     [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{user}',              [UserManagementController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit',         [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',              [UserManagementController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/activate',   [UserManagementController::class, 'activate'])->name('users.activate');
        Route::patch('/users/{user}/deactivate', [UserManagementController::class, 'deactivate'])->name('users.deactivate');

        // ─── REPORTS ──────────────────────────────────────────
        Route::get('/reports',             [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/access-logs', [ReportController::class, 'accessLogs'])->name('reports.access-logs');

        // ─── ADMIN: RECOMMENDATIONS ───────────────────────────
        Route::get('/admin/recommendations',                        [RecommendationController::class, 'adminIndex'])->name('recommendations.admin');
        Route::patch('/admin/recommendations/{recommendation}',     [RecommendationController::class, 'updateStatus'])->name('recommendations.status');

        // ─── ADMIN: RESOURCE REQUESTS ─────────────────────────
        Route::get('/admin/resource-requests',                          [ResourceRequestController::class, 'adminIndex'])->name('resource-requests.admin');
        Route::patch('/admin/resource-requests/{resourceRequest}',      [ResourceRequestController::class, 'updateStatus'])->name('resource-requests.status');
    });
});