<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\TimingController;
use App\Models\Transaction;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/transactions', function () {
    return Transaction::all();
});

Route::prefix('transactions')->group(function () {
    Route::get('totalCosts', [TransactionController::class, 'totalCosts']);
    Route::get('totalEarnings', [TransactionController::class, 'totalEarnings']);
    Route::get('totalBalance', [TransactionController::class, 'totalBalance']);
    Route::get('months', [TransactionController::class, 'getMonthTransactions']);
});

Route::prefix('categories')->group(function () {
    Route::get('tree', [CategoryController::class, 'getTree']);
});

Route::prefix('states')->group(function () {
    Route::get('tree', [StateController::class, 'getTree']);
});

Route::prefix('timings')->group(function () {
    Route::get('tree', [TimingController::class, 'getTree']);
});

Route::prefix('methods')->group(function () {
    Route::get('tree', [MethodController::class, 'getTree']);
});

Route::apiResources([
    'transactions' => TransactionController::class,
    'categories' => CategoryController::class,
    'labels' => LabelController::class,
    'methods' => MethodController::class,
    'states' => StateTypeController::class,
    'timings' => TimingController::class
]);
