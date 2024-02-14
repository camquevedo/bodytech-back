<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\AuthController;
use App\Http\Controllers\Products\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(
//     [
//         'prefix' => '/',
//         'namespace' => 'Auth',
//         'middleware' => ['auth:sanctum'],
//     ],
//     function () {
//         Route::get('/', [AuthController::class, 'getAll']);
//         Route::get('/{id}', [AuthController::class, 'getById']);
//         Route::post('/', [AuthController::class, 'create']);
//         Route::put('/{id}', [AuthController::class, 'update']);
//         Route::delete('/', [AuthController::class, 'delete']);
//         Route::get('/mails/{id}', [AuthController::class, 'sendMailToUsersByIdAndWinnerBidId']);
//         Route::get('/status/{id}', [AuthController::class, 'setStatusById']);
//     }
// );

Route::group(
    [
        'prefix' => '/products',
        'namespace' => 'Products',
        // 'middleware' => ['auth:sanctum'],
        // 'middleware' => [],
    ],
    function () {
        Route::get('/', [ProductController::class, 'getAll']);
        Route::get('/{id}', [ProductController::class, 'getById']);
        Route::post('/', [ProductController::class, 'create']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
    }
);

// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::resource('products', 'App\Http\Controllers\ProductController');
// });

Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World!']);
});
