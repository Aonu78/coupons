<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserTransformer;
use App\Http\Controllers\Api\UsersBankController;
use App\Http\Controllers\Api\Shop\ShopController;
use App\Http\Controllers\Api\Game\GamesController;
use App\Http\Controllers\Api\User\StripeController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\Shop\CompanyController;
use App\Http\Controllers\Api\User\WithdrawController;
use App\Http\Controllers\Api\Shop\LocationsController;
use App\Http\Controllers\Api\Coupons\CouponsController;
use App\Http\Controllers\Api\User\AffiliationController;
use App\Http\Controllers\Api\User\TransactionsController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Tournaments\TournamentsController;
use App\Http\Controllers\Api\Shop\CouponsController as ShopCouponsController;
use App\Http\Controllers\Api\Shop\AuthenticationController as ShopAuthenticationController;
use App\Http\Controllers\Api\Admin\AuthenticationController as AdminAuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('authentication')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('login/google', [AuthenticationController::class, 'loginByGoogle']);
    Route::post('login/line', [AuthenticationController::class, 'loginByLine']);
    Route::post('login/apple', [AuthenticationController::class, 'loginByApple']);
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::post('password/otp', [AuthenticationController::class, 'changePassword']);
    Route::put('password', [AuthenticationController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', function (Request $request) {
            return response()->json([
                "data" => new UserTransformer($request->user())
            ]);
        });

        Route::get('invited', [AffiliationController::class, 'index']);

        Route::prefix('billing')->group(function () {
            Route::post('', [StripeController::class, 'charge']);

            Route::get("intent", [StripeController::class, "getIntent"]);
            Route::get("key", [StripeController::class, "getKey"]);

            Route::prefix('methods')->group(function () {
               Route::get("/", [StripeController::class, "getPaymentMethods"]);
               Route::post("/", [StripeController::class, "savePaymentMethod"]);
               Route::delete("/", [StripeController::class, "deletePaymentMethod"]);

               Route::put("/default", [StripeController::class, "updateDefaultPaymentMethod"]);
            });

            Route::get('fake', [StripeController::class, 'getFakeCard']);
            Route::post('fake', [StripeController::class, 'saveFakeCard']);
        });

        Route::prefix('bank-account')->group(function () {
            Route::get('/', [UsersBankController::class, 'getBank']);
            Route::post('/', [UsersBankController::class, 'save']);
        });

        Route::prefix("transactions")->group(function () {
            Route::get("/", [TransactionsController::class, "getTransactions"]);
            Route::get("/usd", [TransactionsController::class, "getUsdTransactions"]);
            Route::get("/cp", [TransactionsController::class, "getCPTransactions"]);
        });

        Route::prefix("withdraws")->group(function () {
            Route::get("/{status?}", [WithdrawController::class, "getWithdraws"]);
            Route::post("/", [WithdrawController::class, "create"]);
        });

        Route::patch('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'updatePassword']);
        Route::delete('/', [ProfileController::class, 'destroy']);
    });

    Route::prefix('games')->group(function () {
        Route::get('/', [GamesController::class, "getAllPaginatedGames"]);
        Route::get('/all', [GamesController::class, "getAllGames"]);
        Route::get('/search', [GamesController::class, "searchGames"]);

        Route::get('/categories', [GamesController::class, "getCategories"]);
        Route::get('/categories/{id}', [GamesController::class, "findCategory"]);

        Route::get('/{id}', [GamesController::class, "findGame"]);
    });

    Route::prefix('coupons')->group(function () {
       Route::get('/', [CouponsController::class, 'index']);

       Route::prefix('my')->group(function () {
          Route::get('/', [CouponsController::class, 'myCoupons']);
          Route::post('/', [CouponsController::class, 'buyCoupon']);


          Route::get('/used', [CouponsController::class, 'getUsedCoupons']);
          Route::get('/{id}/code', [CouponsController::class, 'getBoughtCouponCode']);
       });

       Route::prefix('favourites')->group(function () {
           Route::get('/', [CouponsController::class, 'myFavouriteCoupons']);
           Route::post('/', [CouponsController::class, 'triggerFavouriteCoupon']);
       });
    });
});

Route::prefix('shop')->group(function () {
   Route::prefix('authentication')->group(function () {
        Route::post('login', [ShopAuthenticationController::class, 'login']);
        Route::post('register', [ShopAuthenticationController::class, 'register']);
   });

   Route::middleware('auth:sanctum')->group(function () {
       Route::prefix("my")->group(function () {
           Route::get('/', [ShopController::class, 'getMyShop']);
           Route::post('/', [ShopController::class, 'saveShop']);
       });

       Route::get("locations", [LocationsController::class, "find"]);
       Route::get("stats", [ShopCouponsController::class, "getStats"]);

        //TODO: Remove
        Route::prefix("company")->group(function () {
            Route::get('', [CompanyController::class, "getUserCompany"]);
            Route::post('', [CompanyController::class, "saveCompany"]);
        });

        Route::prefix('coupons')->group(function () {
            Route::get('/', [ShopCouponsController::class, "index"]);
            Route::get('/{id}', [ShopCouponsController::class, "find"]);
            Route::post('/', [ShopCouponsController::class, "create"]);
            Route::patch('/{id}', [ShopCouponsController::class, "update"]);
            Route::delete('/{id}', [ShopCouponsController::class, "delete"]);

            Route::post('/{id}/games', [ShopCouponsController::class, "associateWithGame"]);

            Route::prefix('bought')->group(function () {
               Route::get("/{id}", [ShopCouponsController::class, "findBoughtCoupon"]);
               Route::post("/{id}", [ShopCouponsController::class, "useBoughtCoupon"]);
            });
        });
   });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        "data" => new UserTransformer($request->user())
    ]);
});

Route::prefix('tournaments')->middleware('auth:sanctum')->group(function () {
    Route::get('', [TournamentsController::class, 'getActiveTournament']);
    Route::get('history', [TournamentsController::class, 'getTournamentHistory']);
    Route::get('history/my', [TournamentsController::class, 'getAllTournamentHistory']);
    Route::post('', [TournamentsController::class, 'createTournament']);
    Route::get('{id}', [TournamentsController::class, 'getTournament']);
    Route::post('players', [TournamentsController::class, 'join']);

    Route::prefix("match")->group(function () {
        Route::post('start', [TournamentsController::class, 'startMatch']);
        Route::post('finish', [TournamentsController::class, 'finishMatch']);
    });
});

Route::prefix('admin')->group(function () {
   Route::post('authentication/login', [AdminAuthenticationController::class, 'login']);
});
