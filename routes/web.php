<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});


// require __DIR__.'/api.php';


// Route::get('/time', function () {
//     return now('UTC')->toDateTimeString();
// });



// Route::get('/test-mail', function () {
//     Mail::raw('Hello from test!', function ($message) {
//         $message->to('test@example.com')
//                 ->subject('Test Mail');
//     });

//     return 'Mail sent!';
// });


Route::get('/admin', function () {
    return view('login');
});
Route::get('/admin/dashboard', [App\Http\Controllers\Dashboard::class, 'index'])
    ->name('admin.dashboard');
Route::post('/admin/login', [App\Http\Controllers\AdminAuth::class, 'login'])
    ->name('admin.login');
Route::post('/admin/logout', [App\Http\Controllers\AdminAuth::class, 'logout'])
    ->name('admin.logout');

Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])
    ->name('users');
Route::put('/users/update/{id}', [App\Http\Controllers\UsersController::class, 'update'])
    ->name('users.update');
Route::put('/users/addbalance/{id}', [App\Http\Controllers\UsersController::class, 'addbalance'])
    ->name('users.addbalance');
Route::post('/users/store', [App\Http\Controllers\UsersController::class, 'store'])
    ->name('users.store');
Route::delete('/users/delete/{id}', [
    App\Http\Controllers\UsersController::class,
    'delete'
])
    ->name('users.delete');






// offices

Route::get('/offices', [App\Http\Controllers\OfficeController::class, 'index'])
    ->name('offices');
Route::put('/offices/update/{id}', [App\Http\Controllers\OfficeController::class, 'update'])
    ->name('offices.update');
Route::post('/offices/store', [App\Http\Controllers\OfficeController::class, 'store'])
    ->name('offices.store');
Route::delete('/offices/delete/{id}', [
    App\Http\Controllers\OfficeController::class,
    'delete'
])
    ->name('offices.delete');



// transactions

Route::get(
    '/transactions',
    [App\Http\Controllers\TransactionController::class, 'index']
)->name('transactions');

Route::delete(
    '/transactions/delete/{id}',
    [App\Http\Controllers\TransactionController::class, 'delete']
)->name('transactions.delete');

Route::put(
    '/transactions/status/{id}',
    [App\Http\Controllers\TransactionController::class, 'changestatus']
)->name('transactions.status');








// tracking

Route::get('/tracking', [App\Http\Controllers\TrackingController::class, 'index'])
    ->name('tracking');
Route::post('/tracking/{mtcn}', [App\Http\Controllers\TrackingController::class, 'tracking'])
    ->name('tracking.tracking');



    // tickets

    Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'index'])
        ->name('tickets');

    Route::delete('/tickets/{id}', [App\Http\Controllers\TicketController::class, 'delete'])
        ->name('tickets.delete');
    Route::post('/tickets/response', [App\Http\Controllers\TicketController::class, 'response'])
        ->name('tickets.response');











        // user status
        Route::post('/userstatus/{id}', [UsersController::class, 'changestatus'])
            ->name('userstatus.update');