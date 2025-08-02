<?php

use App\Http\Controllers\api\AuthController;
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


Route::post('/register' , [AuthController::class , 'register']);
Route::post('/verifycode' , [AuthController::class , 'verifyCode']);
Route::post('/resendverificationcode' , [AuthController::class , 'resendVerificationCode']);
Route::post('/login' , [AuthController::class , 'login']);
// Route::middleware('auth:sanctum')->prefix('api')->group(function () {
// });