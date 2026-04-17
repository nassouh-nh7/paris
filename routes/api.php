<?php

use App\Http\Controllers\Api\AuthOtpController;
use App\Http\Controllers\Api\DressController;
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PromoBannerController;
use App\Http\Controllers\Api\StoreController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/send-otp', [AuthOtpController::class, 'send']);
Route::post('/auth/verify-otp', [AuthOtpController::class, 'verify']);
Route::get('/dresses', [DressController::class, 'index']);
Route::get('/dresses/{dress}', [DressController::class, 'show']);
Route::post('/dresses', [DressController::class, 'store']);
Route::get('/stores', [StoreController::class, 'index']);
Route::get('/stores/{store}', [StoreController::class, 'show']);
Route::get('/promo-banners', [PromoBannerController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/listings', [ListingController::class, 'index']);
Route::post('/listings', [ListingController::class, 'store']);
Route::put('/listings/{listing}', [ListingController::class, 'update']);
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);
