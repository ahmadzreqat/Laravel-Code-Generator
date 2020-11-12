<?php


use generator\Http\controller\GeneratorController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => config('generator.prefix'),
    'middleware' => config('generator.middleware')
], function () {

    Route::get('/', [GeneratorController::class, 'index'])->name('gen.form');

    Route::post('/store', [GeneratorController::class, 'store'])->name('gen.post');

});
