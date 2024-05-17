<?php

use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\RoundController;
use App\Http\Controllers\Api\V1\TournamentController;
use App\Http\Controllers\Api\V1\TournamentMatchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
    // 赛事相关的 API 路由
    Route::apiResource('tournament', TournamentController::class);

    // 比赛相关的 API 路由
    Route::apiResource('match', TournamentMatchController::class);

    // 国家相关的 API 路由
    Route::apiResource('country', CountryController::class);

    // 会员相关的 API 路由
    Route::apiResource('member', MemberController::class);

    // Route::post('/round/{round}/winner', [RoundController::class, 'setWinner'])->name('set.winner');
});
