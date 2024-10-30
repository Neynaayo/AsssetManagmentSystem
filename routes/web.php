<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
// Route::get('/', function () {
//     return view('frontend.index');
// });

//READ
Route::get('Asset',[App\Http\Controllers\AssetController::class, 'index']);
//CREATE
Route::get('Asset/create',[App\Http\Controllers\AssetController::class,'create']);
Route::post('Asset/create',[App\Http\Controllers\AssetController::class,'store']);
//EDIT
Route::get('Asset/{id}/edit',[App\Http\Controllers\AssetController::class,'edit']);
Route::put('Asset/{id}/edit',[App\Http\Controllers\AssetController::class,'update']);
//DELETE
Route::get('Asset/{id}/delete',[App\Http\Controllers\AssetController::class,'destroy']);
//SEARCH
Route::get('Asset', [App\Http\Controllers\AssetController::class, 'index']);

//for import Excel
Route::get('Asset/import',[App\Http\Controllers\AssetController::class,'import']);
Route::post('Asset/import',[App\Http\Controllers\AssetController::class,'importExcelData']);

//for Export Excel
Route::get('Asset/export', [App\Http\Controllers\AssetController::class, 'export']);

//For QR Code
// Show QR Code
Route::get('Asset/{id}/qr-code', [App\Http\Controllers\AssetController::class, 'showQrCode'])->name('assets.qrCode');
// Asset Details Page (optional)
Route::get('Asset/{id}/details', [App\Http\Controllers\AssetController::class, 'show'])->name('assets.details');

//for asset count
Route::get('/dashboard', [App\Http\Controllers\AssetController::class, 'dashboard'])->name('dashboard');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
