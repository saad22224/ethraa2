<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CardController;
use App\Http\Controllers\api\TicketController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\TransferController;
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

// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);

//     return ['token' => $token->plainTextToken];
// });


Route::post('/register', [AuthController::class, 'register']);
Route::post('/verifycode', [AuthController::class, 'verifyCode']);
Route::post('/resendverificationcode', [AuthController::class, 'resendVerificationCode']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/user-delete', [AuthController::class, 'delete']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/deviceToken', [AuthController::class, 'deviceToken']);
    Route::post('/send-ticket', [TicketController::class, 'send']);
    Route::post('/transfer', [TransferController::class, 'transfer']);
    Route::post('/transaction', [TransactionController::class, 'transaction']);
    Route::post('/create-card', [CardController::class, 'createCard']);
    Route::get('/getMoneyReceipts', [TransactionController::class, 'getMoneyReceiptsByCountry']);
});
