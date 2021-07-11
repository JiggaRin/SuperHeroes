<?php

use App\Http\Controllers\SuperHeroes\SuperHeroesController;
use Illuminate\Support\Facades\Route;

//Superheroes routes
Route::get('/home', [SuperHeroesController::class, 'index'])->name('super_heroes');
Route::get('/super_heroes_list', [SuperHeroesController::class, 'SuperHeroList'])->name('super_heroes_list');
Route::get('/create', [SuperHeroesController::class, 'create'])->name('super_heroes_create');
Route::get('/edit/{id}', [SuperHeroesController::class, 'edit'])->name('super_heroes_edit');
Route::put('/update/{id}', [SuperHeroesController::class, 'update'])->name('super_heroes_update');
Route::put('/store', [SuperHeroesController::class, 'store'])->name('super_heroes_store');
Route::get('/bulk_delete', [SuperHeroesController::class, 'bulkDelete'])->name('bulk_delete');
