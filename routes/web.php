<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});


// require __DIR__.'/api.php';


Route::get('/time', function () {
    return now('UTC')->toDateTimeString();
});



Route::get('/test-mail', function () {
    Mail::raw('Hello from test!', function ($message) {
        $message->to('test@example.com')
                ->subject('Test Mail');
    });

    return 'Mail sent!';
});