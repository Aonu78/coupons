<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('coupons.index');
    })->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/company', [CompanyController::class, 'index'])->name('profile.company');
        Route::post('/company', [CompanyController::class, 'update'])->name('profile.company.update');
    });

    Route::prefix('coupons')->group(function () {
        Route::get('/', [CouponsController::class, 'index'])->name('coupons.index');
        Route::get('/add', [CouponsController::class, 'add'])->name('coupons.add');
        Route::post('/', [CouponsController::class, 'create'])->name('coupons.create');
        Route::get('/edit/{id}', [CouponsController::class, 'edit'])->name('coupons.edit');
        Route::post('/edit/{id}', [CouponsController::class, 'update'])->name('coupons.update');
    });
});

Route::get('/coupon/{id}/use', [CouponsController::class, 'usePage'])->name('coupons.use');
Route::post('/coupon/{id}/use', [CouponsController::class, 'use'])->name('coupons.use.process');

require __DIR__.'/auth.php';
