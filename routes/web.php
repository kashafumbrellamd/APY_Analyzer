<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Stories;
use App\Models\State;
use App\Models\Cities;
use App\Models\Packages;
use App\Models\Bank;
use App\Models\StandardReportList;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    // $states = State::where('country_id',233)->get();
    // $cities = Cities::where('country_id',233)->get();
    $packages = Packages::get();
    $standard_report_list = StandardReportList::where('status','1')->get();
    return view('home_page',compact('packages','standard_report_list'));
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');
Route::middleware(['packages'])->group(function () {
});

Route::get('/Survey/form', function () {
    $states = State::where('country_id',233)->get();
    $cities = Cities::where('country_id',233)->get();
    return view('surveyForm',['states'=>$states, 'cities'=>$cities]);
})->name('survey_form');

Route::get('/signin', function () {
    return view('landing_page');
})->name('/signin');

Route::get('/signup', function () {
    return view('customer_bank.signup');
})->name('signup');

Route::get('/customerPackage/{id}', function ($id) {
    return view('customer_bank.customer_package',compact('id'));
})->name('customer_package');

Route::get('/invoice/{id}/{type}', function ($id,$type) {
    return view('customer_bank.invoice',compact('id','type'));
})->name('invoice');

Route::get('/payment/{id}/{type}', function ($id,$type) {
    return view('customer_bank.payment',compact('id','type'));
})->name('payment');

Route::get('/interesting_stories', function () {
    $stories = Stories::where('status','1')->get();
    return view('interesting_stories',['stories'=>$stories]);
})->name('interesting_stories');

Route::get('/view_feedback', function () {
    return view('view_feedback');
})->name('view_feedback');

Route::post('/post_feedback', function (Request $request) {
    DB::table('contact_us')->insert([
        'name'=> $request->name,
        'email'=> $request->email,
        'message'=> $request->message,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return redirect()->back()->with('success','Thank you for the feedback.');
})->name('post_feedback');


Auth::routes();
Route::get('/update/prices/{id}', [App\Http\Controllers\GeneralController::class,'update_price']);
Route::post('/update/prices', [App\Http\Controllers\GeneralController::class,'post_update_price'])->name('update_price');
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
Route::get('/view/detailed/customer/bank/{id}', [App\Http\Controllers\GeneralController::class,'view_detailed_customer_bank']);
Route::get('/view/bank/reports', [App\Http\Controllers\GeneralController::class,'view_bank_reports']);
Route::get('/view/detailed/reports', [App\Http\Controllers\GeneralController::class,'view_detailed_reports']);
Route::get('/view/special/reports', [App\Http\Controllers\GeneralController::class,'view_speical_reports']);
Route::get('/bank/type', [App\Http\Controllers\GeneralController::class,'bank_type']);
Route::get('/manage/stories', [App\Http\Controllers\GeneralController::class,'manage_stories']);
Route::get('/manage/charity', [App\Http\Controllers\GeneralController::class,'manage_charity']);
Route::get('/view/seperate/reports', [App\Http\Controllers\GeneralController::class,'seperate_reports']);
Route::get('/view/summary/reports', [App\Http\Controllers\GeneralController::class,'summary_reports']);
Route::get('/view/bank/request', [App\Http\Controllers\GeneralController::class,'bank_request']);
Route::get('/view/registered/bank', [App\Http\Controllers\GeneralController::class,'view_registered_bank']);
//Route::get('/managee/charity', App\Http\Livewire\ManageCharity::class);
Route::get('/manage/packages', [App\Http\Controllers\GeneralController::class,'manage_packages']);
Route::get('/standard/metropolitan/area', [App\Http\Controllers\GeneralController::class,'standard_metropolitan_area']);
Route::get('/customize/packages', [App\Http\Controllers\GeneralController::class,'customize_packages']);
Route::get('/view/customization/requests', [App\Http\Controllers\GeneralController::class,'view_customization_requests']);


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
Route::get('/mhlChartNonCD', [App\Http\Controllers\GeneralController::class,'mhlChartNonCD']);
Route::get('/mamChartNonCD', [App\Http\Controllers\GeneralController::class,'mamChartNonCD']);

Route::get('/getLabels', [App\Http\Controllers\GeneralController::class,'getLabels']);
Route::get('/getNonCDLabels', [App\Http\Controllers\GeneralController::class,'getNonCDLabels']);


Route::get('/add_packages',[App\Http\Controllers\GeneralController::class,'add_packages']);
Route::post('/bank_request_submit',[App\Http\Controllers\GeneralController::class,'bank_request_submit'])->name('bank_request_submit');

Route::get('/flush_cache',[App\Http\Controllers\GeneralController::class,'flush_cache']);

Route::get('/replace_names',function(){
        $filePath = public_path('Replacements.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Remove the header row if needed
        $headerRow = array_shift($rows);

        $data = [];
        foreach ($rows as $row) {
            $data[] = array_combine($headerRow, $row);
        }
        // Data here ok
        foreach ($data as $dt) {
            if($dt['Website'] != null){
                $banks = Bank::where('name',$dt['Website'])->get();
                if(count($banks) > 0){
                    foreach($banks as $bank){
                        if ($dt['Client Requirement'] != null) {
                            $bank->name = $dt['Client Requirement'];
                            $bank->save();
                        }
                    }
                }
            }
        }
    });
