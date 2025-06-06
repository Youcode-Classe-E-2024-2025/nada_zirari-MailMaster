<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/campaigns/{id}/email-open', [CampaignController::class, 'emailOpen']);

Route::post('/campaigns/{id}/send', [CampaignController::class, 'sendCampaign']);
Route::get('/campaigns/{id}/preview', [CampaignController::class, 'preview']);

Route::middleware(['auth:sanctum', 'web'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('newsletters', NewsletterController::class);

    Route::apiResource('subscribers', SubscriberController::class);

    Route::apiResource('campaigns', CampaignController::class);
});