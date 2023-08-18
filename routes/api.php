<?php

use Illuminate\Http\Request;
use App\Http\Controllers\api\{AuthController};
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckOwnership;
use App\Http\Controllers\api\{AuthController, UserController};

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

        Route::post('/register', [AuthController::class, 'register'])->name('register');
       
        Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
       
        Route::post('/signout', [AuthController::class, 'signout'])->name('signout');
    
        Route::get('/genre', [GenreController::class, 'index'])->name('genre.index');

        Route::post('/genre/{id}', [GenreController::class, 'show'])->name('genre.show');
    });



    // Declare authenticated routes

    Route::prefix('admin')->group(function () {

        Route::prefix('genre')->group(function () {
            
            Route::post('/create', [GenreController::class, 'store'])->name('genre.store');
            Route::post('/update', [GenreController::class, 'update'])->name('genre.update');
            Route::post('/delete', [GenreController::class, 'delete'])->name('genre.delete');
        });
    });


  

        Route::group(['middleware' => ['auth:api']], function() {

            Route::group(['prefix' => 'users'],  static function () {

                Route::group(['middleware' => [CheckOwnership::class]], static function () {
                    Route::put('/{id}', [UserController::class, 'update'])->name('user-update-self');
                    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users-delete-self');
                });

                Route::get('/', [UserController::class, 'index'])->name('get-users');
                Route::get('/{id}', [UserController::class, 'show'])->name('show-user');
                Route::get('producers', [UserController::class, 'getProducers'])->name('get-producers');
                Route::get('artistes', [UserController::class, 'getArtistes'])->name('get-artistes');
        });
    });

}); 
