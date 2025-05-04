<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FruitController;

Route::get('/', [FruitController::class, 'index']);
Route::get('/create', [FruitController::class, 'create'])->name('fruit.create');
Route::post('/store', [FruitController::class, 'store'])->name('fruit.store');
Route::get('/export', [FruitController::class, 'export'])->name('fruit.export');

