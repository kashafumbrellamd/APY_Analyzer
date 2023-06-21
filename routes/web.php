<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
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

Auth::routes();
Route::get('/role/permissions', [App\Http\Controllers\RolesController::class,'role_permission']);
Route::resource('role', App\Http\Controllers\RolesController::class);
Route::get('/abc', [App\Http\Controllers\HomeController::class, 'index'])->name('abc');
Route::get('/roles', [App\Http\Controllers\PermissionController::class,'Permission']);
Route::get('/add_permisiion/{permissoon}', [App\Http\Controllers\PermissionController::class,'add_permisiion']);
Route::get('/manage/users', [App\Http\Controllers\RolesController::class,'manage_users']);
Route::get('/add/users', [App\Http\Controllers\RolesController::class,'add_users']);
Route::get('/manage/banks', [App\Http\Controllers\GeneralController::class,'manage_banks']);
Route::get('/add/bank/rates', [App\Http\Controllers\GeneralController::class,'add_bank_rates']);
Route::get('/manage/rate/types', [App\Http\Controllers\GeneralController::class,'manage_rate_types']);


Route::get('/verify/{code}', [App\Http\Controllers\PermissionController::class,'verify_email']);
Route::get('/user/password/reset/{id}', [App\Http\Controllers\PermissionController::class,'password_reset'])->name('user_password_reset');
Route::post('/user/password/reset', [App\Http\Controllers\PermissionController::class,'password_update'])->name('password_update');



Route::get('/email',function(){
    Mail::to("moaz.muhammad@yopmail.com")->send(new TestMail());
});
