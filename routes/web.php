<?php

use App\Http\Controllers\Main\IndexController;
use Illuminate\Support\Facades\Route;









Route::middleware('auth')->name('main.')->group(function () {
Route::get('/', indexController::class)->name('index');
Route::prefix('tasks')->name('tasks.')->group(function () {
    Route::get('/create', \App\Http\Controllers\Task\CreateController::class)->name('create');
    Route::post('/store', \App\Http\Controllers\Task\StoreController::class)->name('store');
    Route::get('/{todo}', \App\Http\Controllers\Task\ShowController::class)->name('show');
    Route::delete('/{todo}', \App\Http\Controllers\Task\DeleteController::class)->name('delete');
    Route::get('/{todo}/edit}', \App\Http\Controllers\Task\EditController::class)->name('edit');
    Route::patch('/{todo}', \App\Http\Controllers\Task\UpdateController::class)->name('update');
});

});



Auth::routes();


