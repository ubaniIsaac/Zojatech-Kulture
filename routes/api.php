<?php

use Illuminate\Http\Request;
use App\Http\Controllers\api\{AuthController, BeatController, GenreController};
use Illuminate\Support\Facades\Route;

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


  
}); 
