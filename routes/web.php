<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\Authenticate;


Route::get('/home', [ListingController::class,'index'])->name('home.index');
Route::get('/home/create', [ListingController::class,'create'])->name('home.create');
Route::post('/home', [ListingController::class,'store'])->name('home.store');
Route::get('/home/manage', [ListingController::class,'manage'])->name('home.manage');
Route::get('/home/{id}/edit', [ListingController::class,'edit'])->name('home.edit');
Route::put('/home/{id}/', [ListingController::class,'update'])->name('home.update');
Route::get('/home/{id}/', [ListingController::class,'show'])->name('home.show');
Route::delete('/home/{id}/', [ListingController::class,'delete'])->name('home.destroy');




Route::get('/register', [UserController::class,'create'])->name('user.create');
Route::post('/users', [UserController::class,'store'])->name('user.store');
Route::post('/logout', [UserController::class,'logout'])->name('user.logout');
Route::get('/login', [UserController::class,'login'])->name('login');
Route::post('/users/login',[UserController::class,'loggedin'])->name('user.loggedin');

