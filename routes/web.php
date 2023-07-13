<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Stories;
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
    if(!Auth::check()){
        return view('landing_page');
    }else{
        return redirect()->route('login');
    }
});
Route::get('/',function(){
    $stories = Stories::where('status','1')->get();
    if(!Auth::check()){
        return view('home_page',['stories'=>$stories]);
    }else{
        return view('home_page',['stories'=>$stories]);
    }
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::get('/signin', function () {
    return view('landing_page');
})->name('/signin');

Route::get('/signup', function () {
    return view('customer_bank.signup');
})->name('signup');

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
Route::get('/add/customer/bank', [App\Http\Controllers\GeneralController::class,'add_customer_bank']);
Route::get('/view/customer/bank/admin', [App\Http\Controllers\GeneralController::class,'customer_bank_admin']);
Route::get('/customer/bank/user', [App\Http\Controllers\GeneralController::class,'customer_bank_user']);
Route::get('/view/bank/reports', [App\Http\Controllers\GeneralController::class,'view_bank_reports']);
Route::get('/view/detailed/reports', [App\Http\Controllers\GeneralController::class,'view_detailed_reports']);
Route::get('/view/special/reports', [App\Http\Controllers\GeneralController::class,'view_speical_reports']);
Route::get('/bank/type', [App\Http\Controllers\GeneralController::class,'bank_type']);
Route::get('/manage/stories', [App\Http\Controllers\GeneralController::class,'manage_stories']);
Route::get('/manage/charity', [App\Http\Controllers\GeneralController::class,'manage_charity']);
Route::get('/view/seperate/reports', [App\Http\Controllers\GeneralController::class,'seperate_reports']);
Route::get('/view/summary/reports', [App\Http\Controllers\GeneralController::class,'summary_reports']);
//Route::get('/managee/charity', App\Http\Livewire\ManageCharity::class);


Route::get('/verify/{code}', [App\Http\Controllers\PermissionController::class,'verify_email']);
Route::get('/user/password/reset/{id}', [App\Http\Controllers\PermissionController::class,'password_reset'])->name('user_password_reset');
Route::post('/user/password/reset', [App\Http\Controllers\PermissionController::class,'password_update'])->name('password_update');

Route::post('/bank/login', [App\Http\Controllers\GeneralController::class,'bank_login'])->name('bank_login');
Route::get('/otp/apply/login/{id}', [App\Http\Controllers\GeneralController::class,'otp_apply'])->name('otp_apply');
Route::post('/verify/login', [App\Http\Controllers\GeneralController::class,'verify_login'])->name('verify_login');



Route::get('/email',function(){
    Mail::to("moaz.muhammad@yopmail.com")->send(new TestMail());
});


Route::get('/mhlChart', [App\Http\Controllers\GeneralController::class,'mhlChart']);
Route::get('/mamChart', [App\Http\Controllers\GeneralController::class,'mamChart']);

Route::get('/getLabels', [App\Http\Controllers\GeneralController::class,'getLabels']);


Route::get('/add_packages',[App\Http\Controllers\GeneralController::class,'add_packages']);
