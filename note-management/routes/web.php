<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function(){
    return view('register');
})->name('register');

Route::get('/login', function(){
    return view('login');
})->name('login');



// Route::get('/dashboard', function(){
//     return view('note.manage');
// })->name('dashboard');

Route::post('/register/store', [AdminController::class, 'registerstore'])->name('register.store');
Route::post('/user/login', [AdminController::class, 'login'])->name('user.login');
Route::get('/logout', [AdminController::class, 'logout'])->name('user.logout');

Route::group(['middleware' => 'admin'], function() {

    Route::get('/dashboard', [NoteController::class, 'dashboard'])->name('dashboard');    
    Route::get('/note/create', [NoteController::class, 'create'])->name('note.create');
    Route::post('/note/store', [NoteController::class, 'store'])->name('note.store');
    Route::get('/note/edit{id}', [NoteController::class, 'edit'])->name('note.edit');
    Route::post('/note/update{id}', [NoteController::class, 'update'])->name('note.update');
    Route::get('/note/delete{id}', [NoteController::class, 'delete'])->name('note.delete');

    Route::get('/note/search', [NoteController::class,'search'])->name('note.search');
});


