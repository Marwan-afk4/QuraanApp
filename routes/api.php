<?php

use App\Http\Controllers\Api\Admin\Ad3yaController;
use App\Http\Controllers\Api\Admin\AhadethController;
use App\Http\Controllers\Api\Admin\AyatController;
use App\Http\Controllers\Api\Admin\AzkarController;
use App\Http\Controllers\Api\Admin\CodeController;
use App\Http\Controllers\Api\Admin\EmotionController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\PaymentController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\PaymentController as UserPaymentController;
use App\Http\Controllers\Api\User\UserController;
use App\Models\Azkar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::post('/notification/broadcast', [NotificationController::class, 'broadcastNotification']);




Route::middleware(['auth:sanctum', 'IsAdmin'])->group(function () {

    Route::put('/admin/updateLimit', [EmotionController::class, 'editallLimits']);

    Route::get('/admin/getUsersLimit', [EmotionController::class, 'getUsersLimit']);

////////////////////////////////////////////// Azkaaaar ////////////////////////////////////////////////

    Route::get('/admin/getAzkar',[AzkarController::class , 'getAzkar']);

    Route::post('/admin/Azkar/add',[AzkarController::class , 'addAzkar']);

    Route::put('/admin/Azkar/Update/{id}',[AzkarController::class , 'UpdateAzkar']);

    Route::delete('/admin/Azkar/Delete/{id}', [AzkarController::class , 'deleteAzkar']);

    Route::delete('/admin/Azkar/category/Delete/{id}', [AzkarController::class , 'deleteCategory']);

    Route::get('/admin/Azkar/category/{category_id}', [AzkarController::class , 'getAzkarCategory']);

    Route::get('/admin/Azkar/categories', [AzkarController::class , 'getAzkarCategories']);

    Route::post('/admin/Azkar/category/add', [AzkarController::class , 'addAzkarCategory']);

///////////////////////////////////////// Ad3ya /////////////////////////////////////////////////

    Route::get('/admin/getAd3ya',[Ad3yaController::class , 'getAd3ya']);

    Route::post('/admin/Ad3ya/add',[Ad3yaController::class , 'addAd3ya']);

    Route::put('/admin/Ad3ya/Update/{id}',[Ad3yaController::class , 'UpdateAd3ya']);

    Route::delete('/admin/Ad3ya/Delete/{id}', [Ad3yaController::class , 'deleteAd3ya']);

////////////////////////////////////////// Ahadeth /////////////////////////////////////////////////

    Route::get('/admin/getAhadeth',[AhadethController::class , 'getAhadeth']);

    Route::post('/admin/Ahadeth/add',[AhadethController::class , 'addAhadeth']);

    Route::put('/admin/Ahadeth/Update/{id}',[AhadethController::class , 'UpdateAhadeth']);

    Route::delete('/admin/Ahadeth/Delete/{id}', [AhadethController::class , 'deleteAhadeth']);

//////////////////////////////////////////// Ayaaat //////////////////////////////////////////////////

    Route::get('/admin/getAyat',[AyatController::class , 'getAyat']);

    Route::post('/admin/Ayat/add',[AyatController::class , 'addAyat']);

    Route::put('/admin/Ayat/Update/{id}',[AyatController::class , 'UpdateAyat']);

    Route::delete('/admin/Ayat/Delete/{id}', [AyatController::class , 'deleteAyat']);

//////////////////////////////////////// Emotion //////////////////////////////////////////////////

    Route::get('/admin/getEmotion', [EmotionController::class , 'getEmotion']);

    Route::post('/admin/Emotion/add', [EmotionController::class , 'addEmotion']);

    Route::delete('/admin/Emotion/delete/{id}', [EmotionController::class , 'deleteEmotion']);

////////////////////////////////////////// Emotion All //////////////////////////////////////////////////

    Route::post('/admin/EmotionAll/add', [EmotionController::class , 'addtoEmotions']);

    Route::put('/admin/EmotionAll/Update/{id}', [EmotionController::class , 'updateEmotionAll']);

    Route::delete('/admin/EmotionAll/Delete', [EmotionController::class , 'deleteEmotionAllByType']);

    Route::get('/admin/emotionThings/{emotion_id}', [EmotionController::class , 'getemotionthings']);

////////////////////////////////////////////// Code ////////////////////////////////////////////////////

    Route::get('/admin/code/get',[CodeController::class,'getCode']);

    Route::post('/admin/code/add',[CodeController::class,'addCode']);

    Route::delete('/admin/delete/code/{id}',[CodeController::class,'deleteCode']);

///////////////////////////////////////////////// Payments //////////////////////////////////////////////////

    Route::get('/admin/getPayments', [PaymentController::class, 'getPayments']);

    Route::delete('/admin/delete/payment/{id}', [PaymentController::class, 'deletePayment']);

/////////////////////////////////////////// Notifications //////////////////////////////////////////////////

    // Route::post('/admin/Notification/sendToUser', [NotificationController::class, 'sendToUser']);
});


Route::middleware('UUIDAuth')->group(function () {

    Route::post('/user/addFCM',[UserController::class , 'addFCM']);

    Route::get('/user/foryouPage', [UserController::class, 'foryouPage']);

    Route::get('/user/getAd3ya', [UserController::class, 'getAd3ya']);

    Route::get('/user/getAzkar', [UserController::class, 'getAzkar']);

    Route::get('/user/getAhadeth', [UserController::class, 'getAhadeth']);

    Route::get('/user/getAyat', [UserController::class, 'getAyat']);

    Route::get('/user/getEmotions', [UserController::class, 'getEmotions']);

    Route::get('/user/getemotionthings/{emotion_id}', [UserController::class, 'getemotionthings']);

    Route::get('/user/getCategories', [UserController::class, 'getCategories']);

    Route::get('/user/getAzkarCategory/{category_id}', [UserController::class, 'getAzkarCategory']);

    Route::post('/user/addPayment', [UserPaymentController::class, 'addPayment']);

    Route::get('/user/limit', [UserController::class, 'getUsersLimit']);
});
