<?php

use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\FAQController;
use App\Http\Controllers\Api\V1\InformationController;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\PackageController;
use App\Http\Controllers\Api\V1\ReceiptController;
use App\Http\Controllers\Api\V1\RoundController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\TournamentController;
use App\Http\Controllers\Api\V1\TournamentMatchController;
use App\Http\Controllers\Api\V1\UploadController;
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

Auth::routes();

Route::get('/', 'HomeController@Index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/matches', 'MatchesController@index')->name('matches');
Route::get('/subscription', 'HomeController@Subscription')->name('subscription');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::post('/register', 'HomeController@Register')->name('register');
Route::post('/member-login', 'HomeController@Login')->name('member-login');
Route::get('/test', 'HomeController@test')->name('test');

/* Admin */
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

// 确保这些路由只有登录的用户才能访问
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    // Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('/logout', 'AdminController@SignOut')->name('admin.logout');
    Route::get('/password', 'AdminController@ChangePassword');
    Route::post('/password', 'AdminController@ChangePasswordPost');
    Route::get('/profile', 'AdminController@Profile');
    Route::post('/profile', 'AdminController@ProfilePost');
    Route::get('/', 'AdminController@index');
    Route::get('/dashboard', 'AdminController@index');
    Route::get('users', 'AdminController@Users');
    Route::get('user/add', 'AdminController@AddUser');
    Route::post('user/add', 'AdminController@AddUserPost');
    Route::get('user/edit/{id}', 'AdminController@EditUser');
    Route::post('user/edit/', 'AdminController@EditUserPost');
    Route::post('user/delete', 'AdminController@DeleteUserPost');
    Route::post('user/reset', 'AdminController@ResetUserPasswordPost');
    // 显示国家列表页面
    Route::resource('countries', CountryController::class);
    Route::resource('teams', TeamController::class);
    Route::resource('tournaments', TournamentController::class);
    Route::resource('matches', TournamentMatchController::class);
    Route::resource('rounds', RoundController::class);
    Route::resource('members', MemberController::class);
    Route::resource('faqs', FAQController::class);
    Route::resource('informations', InformationController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('receipts', ReceiptController::class);
    Route::resource('subscriptions', SubscriptionController::class);

    // Route::post('/round/{round}/winner', [RoundController::class, 'setWinner'])->name('set.winner');
    // Route::post('/round/{round}/winner', 'RoundController@setWinner');
    Route::get('tournament-match/{tournamentMatch}', [TournamentMatchController::class, 'show']);

    Route::post('upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');
});
Route::group(['middleware' => ['auth']], function () {
    Route::post('change-password', 'HomeController@changePassword')->name('change-password');
    Route::post('upload-receipt', 'UploadController@upload')->name('upload-receipt');
});
Route::post('upload-receipt-email', 'UploadController@uploadEmail')->name('upload-receipt-email');

Route::get('/create-storage-link', function () {
    Artisan::call('storage:link');

    return 'The symbolic link has been created.';
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'zh'])) { // Check if the locale is one of the ones we support
        session()->put('locale', $locale);
    }

    return back();
});

// Route::get('/secure-migrate', function () {
//     try {
//         Artisan::call('migrate', [
//             '--force' => true, // Needed if your app is in production
//         ]);
//         $output = Artisan::output();

//         return response()->json(['message' => 'Migrations run successfully', 'output' => $output]);
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// });
// Route::get('/run-migration', function () {
//     Artisan::call('make:migration', [
//         'name' => 'create_example_table',
//         '--create' => 'example'
//     ]);
//     return "Migration created!";
// });
