<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\DiaryAnalysisController;
use App\Http\Controllers\Api\DiaryController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessfull;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Member;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register_with_google', [AuthController::class, 'register_with_google']);
Route::post('/login_with_google', [AuthController::class, 'login_with_google']);
Route::post('/check_user', [AuthController::class, 'check_user']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

// Article
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article:slug}', [ArticleController::class, 'show']);

// //Diaries
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/diaries', [DiaryController::class, 'store']);
//     Route::get('/diaries', [DiaryController::class, 'index']);
//     Route::get('/diaries/{diary}', [DiaryController::class, 'show']);
//     // Stress & Emotion Analysis
//         Route::get('/diaries/analysis/weekly', [DiaryAnalysisController::class, 'weekly']);
//         Route::get('/diaries/analysis/monthly', [DiaryAnalysisController::class, 'monthly']);
//         Route::get('/diaries/analysis/emotions', [DiaryAnalysisController::class, 'emotionDistribution']);
// });
