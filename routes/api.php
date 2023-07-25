<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\ManagerProfileController;
use App\Http\Controllers\EmailVerificationController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//linking views
Route::get('/signup', function() {
    return view('signup');
})-> name('signup');

Route::get('/login', function() {
    return view('login');
})-> name('login');


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/send-verification-email', [EmailVerificationController::class, 'sendVerificationEmail']) ->name('verification.send');

// Route for verifying the email with the token
Route::get('/verify/{token}', [EmailVerificationController::class, 'verifyEmail'])
    ->name('verification.verify');


//user role modules
Route::group(['middleware' => ['auth:sanctum', EnsureFrontendRequestsAreStateful::class, 'role:user']], function(){
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('dashboard.profile');
    Route::post('/logout', [AuthController::class, 'logout']);
});


//admin modules
Route::group(['middleware' => ['auth:sanctum', EnsureFrontendRequestsAreStateful::class, 'role:admin']], function(){
    Route::get('/admin/dashboard/profile', [AdminProfileController::class, 'index'])->name('admin.dashboard.profile');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/admin/users', UserController::class);
});

Route::group(['middleware' => ['auth:sanctum', EnsureFrontendRequestsAreStateful::class, 'role:manager']], function(){
    Route::get('/manager/dashboard/profile', [ManagerProfileController::class, 'index'])-> name('manager.dashboard.profile');
    Route::post('/logout', [AuthController::class, 'logout']);
});

