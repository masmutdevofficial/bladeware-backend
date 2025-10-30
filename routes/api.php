<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use Carbon\Carbon;

Route::post('/login', [APIController::class, 'login']);
Route::post('/register', [APIController::class, 'register']);
Route::get('/get-profile-data', [APIController::class, 'getProfileData']);
Route::get('/banner', [APIController::class, 'getBannerData']);
Route::patch('/banner/register', [APIController::class, 'setRegisteredBanner']);
Route::post('/bind-wallet', [APIController::class, 'bindWallet']);
Route::get('/get-bind-wallet', [APIController::class, 'getBindWallet']);
Route::post('/request-withdrawal', [APIController::class, 'requestWithdrawal']);
Route::post('/change-login-password', [APIController::class, 'changeLoginPassword']);
Route::post('/change-withdrawal-password', [APIController::class, 'changeWithdrawalPassword']);
Route::get('/get-apps-records', [APIController::class, 'getAppsRecords']);
Route::get('/get-finance', [APIController::class, 'getFinance']);
Route::get('/get-data-boost', [APIController::class, 'getDataBoost']);
Route::get('/get-produk', [APIController::class, 'getProduk']);
Route::post('/submit-produk', [APIController::class, 'submitProduk']);
Route::get('/finance-boost', [APIController::class, 'financeBoost']);
Route::get('/get-data-boost-apps', [APIController::class, 'getDataBoostApps']);
// Combination API for apps
Route::get('/user-combinations', [APIController::class, 'getUserCombinations']);
Route::post('/user-combinations', [APIController::class, 'updateUserCombinations']);
