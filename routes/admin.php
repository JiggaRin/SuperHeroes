<?php
use App\Http\Controllers\SuperHeroesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Superheroes routes
Route::get('/home', [SuperHeroesController::class, 'index'])->name('super-heroes');
Route::get('/super_heroes_list', [SuperHeroesController::class, 'SuperHeroList'])->name('super_heroes_list');
Route::get('/create', [SuperHeroesController::class, 'create'])->name('super-heroes-create');
Route::get('/edit', [SuperHeroesController::class, 'edit'])->name('super-heroes-edit');
Route::get('/bulk_delete', [SuperHeroesController::class, 'bulkDelete'])->name('bulk_delete');


//Dashboard routes
//
