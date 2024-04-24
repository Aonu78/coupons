<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\GamesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WithdrawsController;
use App\Http\Controllers\Admin\TournamentsController;
use App\Http\Controllers\Admin\Auth\AuthenticationController;
use Illuminate\Http\Request;


Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticationController::class, 'create'])
                ->name('admin.login.show');

    Route::post('login', [AuthenticationController::class, 'login'])->name('admin.login');
});

Route::delete('/alluser/users/destroy/{user}', [UsersController::class, 'destroy'])->name('alluser.users.destroy');

Route::middleware('auth:admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::post('locale', function (\Illuminate\Http\Request $request) {
        if (in_array($request->input('locale'), ['en', 'jp'])) {
            $request->session()->put('locale', $request->input('locale'));
        }

        return back();
    })->name('admin.locale');

    Route::post('logout', [AuthenticationController::class, 'logout'])->name('admin.logout');

    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('admin.users.index');
        Route::get('/all/download', [UsersController::class, 'downloadUsersCsv'])->name('admin.users.download.csv');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
    });

    Route::prefix('games')->group(function () {
        Route::get('/', [GamesController::class, 'index'])->name('admin.games.index');
        Route::get('/new', [GamesController::class, 'create'])->name('admin.games.create');
        Route::post('/new', [GamesController::class, 'save'])->name('admin.games.save');

        Route::get('/edit/{id}', [GamesController::class, 'edit'])->name('admin.games.edit');
        Route::post('/edit/{id}', [GamesController::class, 'update'])->name('admin.games.update');
    });

    Route::prefix('tournaments')->group(function () {
        Route::get('/', [TournamentsController::class, 'index'])->name('admin.tournaments.index');
        Route::get('/create', [TournamentsController::class, 'create'])->name('admin.tournaments.create');
        Route::post('/create', [TournamentsController::class, 'save'])->name('admin.tournaments.save');

        Route::get('/{id}', [TournamentsController::class, 'details'])->name('admin.tournaments.details');
    });

    Route::prefix('withdraws')->group(function () {
        Route::get('/', [WithdrawsController::class, 'index'])->name('admin.withdraws.index');
        Route::get('/edit/{id}', [WithdrawsController::class, 'edit'])->name('admin.withdraws.edit');
        Route::post('/edit/{id}', [WithdrawsController::class, 'save'])->name('admin.withdraws.save');
    });

    Route::prefix('coupons')->group(function () {
        Route::get('/', [CouponsController::class, 'index'])->name('admin.coupons.index');
        Route::get('/create', [CouponsController::class, 'create'])->name('admin.coupons.create');
        Route::post('/create', [CouponsController::class, 'save'])->name('admin.coupons.save');
        Route::get('/edit/{id}', [CouponsController::class, 'edit'])->name('admin.coupons.edit');
        Route::post('/edit/{id}', [CouponsController::class, 'update'])->name('admin.coupons.update');

    });

    Route::prefix('settings')->group(function () {
       Route::get('/', [SettingsController::class, 'index'])->name('admin.settings.index');
       Route::post('/', [SettingsController::class, 'save'])->name('admin.settings.save');
    });
});
