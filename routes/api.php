<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthSanctumController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('auth/user/register', [AuthSanctumController::class, 'register'])->name('auth.user.register');
Route::post('auth/user/login', [AuthSanctumController::class, 'login'])->name('auth.user.login');

Route::post('auth/user/logout', [AuthSanctumController::class, 'logout'])->name('auth.user.logout')
    ->middleware('auth:sanctum');



Route::prefix('products')->middleware('auth:sanctum')->as('api.')->group(function() {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{id_product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/add', [ProductController::class, 'store'])->name('products.store');
    Route::put('/edit/{id_product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/delete/{id_product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
