<?php

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

Route::get('/',function(){
    return redirect()->route('login');
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');

// Route::group(['middleware' => 'role:admin'], function() {
//     Route::get('/role/permissions', [App\Http\Controllers\RolesController::class,'role_permission']);
// });


Auth::routes();

Route::resource('role', App\Http\Controllers\RolesController::class);
Route::get('/abc', [App\Http\Controllers\HomeController::class, 'index'])->name('abc');
Route::get('/roles', [App\Http\Controllers\PermissionController::class,'Permission']);
Route::get('/add_permisiion/{permissoon}', [App\Http\Controllers\PermissionController::class,'add_permisiion']);
Route::get('/role/permissions', [App\Http\Controllers\RolesController::class,'role_permission']);
Route::get('/manage/users', [App\Http\Controllers\RolesController::class,'manage_users']);
