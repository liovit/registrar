<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;

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

Route::get('/', function () { return redirect()->route('login'); });

// turn off register route
Auth::routes(['register' => false]);

// register route redirects back
Route::get('/register', function() { return redirect()->back(); });

Route::middleware(['auth'])->group( function() {

    // dashboard routes
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // ajax routes
    Route::get('/workers/get-list', [App\Http\Controllers\WorkersController::class, 'getWorkers'])->name('workers.getworkers');
    Route::get('/companies/get-list', [App\Http\Controllers\CompaniesController::class, 'getCompanies'])->name('companies.getcompanies');

    // dashboard companies routes
    Route::resource('companies', 'App\Http\Controllers\CompaniesController');
    Route::get('/companies/{company}/delete', [App\Http\Controllers\CompaniesController::class, 'delete'])->name('companies.delete');

    // dashboard workers routes
    Route::resource('workers', 'App\Http\Controllers\WorkersController');
    Route::get('/workers/{worker}/delete', [App\Http\Controllers\WorkersController::class, 'delete'])->name('workers.delete');

});

// Route::get('/linkstorage', function() {
//     Artisan::call('storage:link');
// });

// language change route
Route::get('/changelang', [LanguageController::class, 'changeLanguage'])->name('changelang');