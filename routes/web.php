<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// =========================================================
// ADMIN ROUTES
// =========================================================
use App\Http\Middleware\AdminAuth;

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rotte pubbliche (senza middleware)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Rotte protette (solo se loggato)
    Route::middleware(AdminAuth::class)->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // =========================================================
        // GESTIONE AUTO
        // =========================================================
        Route::resource('cars', AdminCarController::class);

        // Upload immagini asincrono (Dropzone)
        Route::post('/cars/upload', [AdminCarController::class, 'upload'])
            ->name('cars.upload');
        // Riordino immagini via drag & drop
        Route::post('/cars/reorder-images', [AdminCarController::class, 'reorderImages'])
            ->name('cars.reorderImages');


        // Eliminazione singola immagine via AJAX
        Route::delete('/cars/image/{id}', [AdminCarController::class, 'deleteImage'])
            ->name('cars.deleteImage');

    });
});


// =========================================================
// PUBLIC ROUTES
// =========================================================
Route::get('/', [HomeController::class, 'index']);
Route::get('/cars', [CarController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send']);
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/auto/{id}', [CarController::class, 'show'])->name('cars.show');