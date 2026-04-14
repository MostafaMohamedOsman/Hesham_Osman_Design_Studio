<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ProfileController;
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

require __DIR__ . '/auth.php';


Route::group(['prefix' => 'admin','middleware' => 'auth'], function () {
    Route::get('/',HomeController::class)->name('home');
    Route::resource('category', CategoryController::class);
    Route::resource('project', ProjectController::class);
    // Image management (reorder / delete) from project show page
    Route::post('project/{project}/images', [ProjectController::class, 'updateImages'])->name('project.update_images');
    Route::resource('img', ImageController::class);
})->middleware('auth');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', HomeController::class)->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
