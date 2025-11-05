<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RawProductController;
use App\Http\Controllers\ProducedProductController;
use App\Http\Controllers\BroughtProductController;
use App\Http\Controllers\DairyProductionController;
use App\Http\Controllers\FreezerTempController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('departments', DepartmentController::class);
    Route::resource('workers', WorkerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('rawproducts', RawProductController::class);
    Route::resource('Freezertemp', FreezerTempController::class);
    Route::resource('produced-products', ProducedProductController::class);
    Route::resource('brought-products', BroughtProductController::class);
    Route::resource('dairy-productions', DairyProductionController::class);

    Route::get('/api/products/{id}/details', [DairyProductionController::class, 'getProductDetails'])->name('products.details');
});

Route::get('/', function () {
    return redirect('/login');
});
