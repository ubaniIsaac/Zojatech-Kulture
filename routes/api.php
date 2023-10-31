<?php

use Illuminate\Http\Request;
use App\Http\Controllers\api\{ArtisteController, UserController, ProducerController, PaymentController};
use App\Http\Controllers\api\{SubscriptionController, AuthController, BeatController, Cartcontroller,  FavouriteController, GenreController, ReferralController};
use App\Http\Controllers\api\{FlagController, SaveForLaterController};
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckOwnership;

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


Route::prefix('v1')->group(function () {


    // Declare unauthenticated routes
    Route::group(['middleware' => 'guest'], function () {

        //Heartbeat route
        Route::any('/', function () {
            return response()->json(['message' => 'Welcome to Kulture Api'], 200);
        })->name('welcome');

        Route::get('/beats/search/{name}', [BeatController::class, 'search'])->name('beats.search');

        Route::post('/register', [AuthController::class, 'register'])->name('register');

        Route::post('/signin', [AuthController::class, 'signin'])->name('signin');

        Route::post('/signout', [AuthController::class, 'signout'])->name('signout');

        Route::get('/logout-device/{device_id}', [AuthController::class, 'logoutDevice'])->name('logout.device');

        Route::get('users/{id}', [UserController::class, 'show'])->name('show-user');


        Route::prefix('genres')->group(function () {
            Route::get('/genre', [GenreController::class, 'index'])->name('genre.index');
            Route::get('/genre/{id}', [GenreController::class, 'show'])->name('genre.show');
        });

        Route::prefix('producers')->group(function () {
            Route::get('/', [ProducerController::class, 'index'])->name('producers.index');
            Route::get('/{id}', [ProducerController::class, 'show'])->name('producers.show');
        });

        Route::prefix('artistes')->group(function () {
            Route::get('/', [ArtisteController::class, 'index'])->name('artistess.index');
            Route::get('/{id}', [ArtisteController::class, 'show'])->name('artistes.show');
        });

        Route::get('/verifyPayment', [PaymentController::class, 'verifyPayment'])->name('verifyTransaction');

        Route::prefix('trending')->group(function () {
            Route::get('/beats', [BeatController::class, 'trending'])->name('beats.trending');
            Route::get('/producers', [ProducerController::class, 'trendingProducers'])->name('producers.trending');
            Route::get('/genres', [GenreController::class, 'trending'])->name('genres.trending');
        });

        Route::prefix('beats')->group(function () {
            Route::get('/{id}', [BeatController::class, 'show'])->name('beats.show');
            Route::get('/', [BeatController::class, 'index'])->name('beats.index');
            Route::get('/filter-by-price', [BeatController::class, 'filterByPrice'])->name('beats.filterByPrice');
            Route::get('/filter', [BeatController::class, 'filterByGenre'])->name('beats.filter');
            Route::post('/{beat}/save-for-later', [SaveForLaterController::class, 'saveBeatForLater'])->name('beats.save-for-later');
        });

        Route::prefix('webhook')->group(function () {
            Route::post('/verify-paystack', [PaymentController::class, 'verifyPaystack'])->name('verifyWebhook');
        });


        
    });



    // Declare authenticated routes
    Route::group(['middleware' => 'auth:api'], static function () {

        //Carts routes
        Route::prefix('carts')->middleware(['role:artiste'])->group(function () {
            Route::post('/add/{beat_id}', [Cartcontroller::class, 'add'])->name('add-beat-to-cart');
            Route::get('/view', [Cartcontroller::class, 'view'])->name('view-all-beats-in-cart');
            Route::delete('/remove/{beat_id}', [Cartcontroller::class, 'destroy'])->name('delete-from-cart');
        });

        //payment routes
        Route::prefix('payment')->middleware(['role:artiste'])->group(function () {
            Route::post('/pay', [PaymentController::class, 'makePayment'])->name('initiatePayment');
            Route::post('/createRecipient', [PaymentController::class, 'createRecipient'])->name('createRecipient');
        });

        Route::post('/payment/withdraw',  [PaymentController::class, 'initiateWithdrawal'])->middleware(['role:producer'])->name('initiatewithdrawal');


        Route::prefix('flag')->group(function () {
            Route::post('/beat', [FlagController::class, 'flagBeat'])->name('flagBeat');
            Route::post('/producer/{producer_id}', [FlagController::class, 'flagProducer'])->name('flagProducer');
        });

        //Admin routes
        Route::prefix('admin')->group(function () {

            //Admin- Subcription routes
            Route::prefix('subscriptions')->group(function () {
                Route::get('/', [SubscriptionController::class, 'index'])->name('subcriptions.index');
                Route::get('/{id}', [SubscriptionController::class, 'show'])->name('subcriptions.show');
                Route::post('/create', [SubscriptionController::class, 'store'])->name('subcriptions.store');
                Route::post('/update', [SubscriptionController::class, 'update'])->name('subcriptions.update');
                Route::post('/delete', [SubscriptionController::class, 'delete'])->name('subcriptions.delete');
            });

            //Admin- Referral routes
            Route::prefix('referral')->group(function () {
                Route::get('/user/{id}', [ReferralController::class, 'getUserDetails'])->name('referral.getUserDetails');
                Route::get('/{referral_code}', [ReferralController::class, 'getCodeDetails'])->name('referral.getCodeDetails');
                Route::get('/', [ReferralController::class, 'index'])->name('referral.index');
            });


            //Admin- Genre routes
            Route::prefix('genre')->group(function () {
                Route::post('/create', [GenreController::class, 'store'])->name('genre.store');
                Route::post('/update', [GenreController::class, 'update'])->name('genre.update');
                Route::post('/delete', [GenreController::class, 'delete'])->name('genre.delete');
            });
        });

        //User routes
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('get-users');

            Route::group(['middleware' => 'isOwner:user'], function () {
                Route::put('/{id}', [UserController::class, 'update'])->name('user-update-self');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('users-delete-self');
            });
        });


        Route::prefix('beats')->middleware(['role:producer'])->group(function () {
            Route::post('/upload', [BeatController::class, 'upload'])->name('beats.upload');

            Route::group(['middleware' => 'isOwner:beat'], function () {
                Route::put('/{id}', [BeatController::class, 'update'])->name('beats.update');
                Route::delete('/{id}', [BeatController::class, 'destroy'])->name('beats.delete');
            });
        });


        Route::prefix('downloads')->group(function () {
            Route::get('/beats/{id}', [BeatController::class, 'download'])->name('beats.download');
        });

        Route::prefix('favourites')->group(function () {
            Route::post('/{id}', [FavouriteController::class, 'store'])->name('favourite.store');
            Route::get('/{id}/beats', [FavouriteController::class, 'index'])->name('favourite.index');
            Route::delete('/{id}', [FavouriteController::class, 'delete'])->name('favourite.delete');
        });
    });
});
