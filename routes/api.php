<?php

use App\Http\Controllers\TransactionController;
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
});

Route::apiResources([
    'transactions' => TransactionController::class,
    'categories' => Category::class,
    'labels' => LabelController::class,
    'methods' => MethodController::class,
    'states' => StateTypeController::class,
    'timings' => TimingController::class
]);
