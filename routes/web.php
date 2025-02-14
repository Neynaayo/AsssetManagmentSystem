<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisposalStatusController;


Route::get('/', function () {
    return view('auth/login');
});
// Route::get('/', function () {
//     return view('frontend.index');
// });


Route::middleware(['role:1,3'])->group(function () {
    // Routes only for SuperAdmin
    
    Route::get('/admin/assets', [AssetController::class, 'adminAssets']);

    //READ Company
    Route::get('Company',[App\Http\Controllers\CompanyController::class, 'index'])->name('companies.index');
    //CREATE Company
    Route::get('Company/create',[App\Http\Controllers\CompanyController::class,'create'])->name('companies.create');
    Route::post('Company/create',[App\Http\Controllers\CompanyController::class,'store'])->name('companies.store');
    //EDIT Company
    Route::get('Company/{id}/edit',[App\Http\Controllers\CompanyController::class,'edit'])->name('companies.edit');
    Route::put('Company/{id}/edit',[App\Http\Controllers\CompanyController::class,'update'])->name('companies.update');
    //DELETE Company
    Route::delete('Company/{id}/delete',[App\Http\Controllers\CompanyController::class,'destroy'])->name('companies.destroy');
    //Import Excel
    Route::get('Company/import',[App\Http\Controllers\CompanyController::class,'import'])->name('companies.import');
    Route::post('Company/import',[App\Http\Controllers\CompanyController::class,'importExcelData'])->name('companies.importExcelData');
   //for Export Excel
   Route::get('Company/export', [App\Http\Controllers\CompanyController::class, 'export'])->name('companies.export');
   

    //READ Department
    Route::get('Department',[App\Http\Controllers\DepartmentController::class, 'index'])->name('departments.index');
    //CREATE Department
    Route::get('Department/create',[App\Http\Controllers\DepartmentController::class,'create'])->name('departments.create');
    Route::post('Department/create',[App\Http\Controllers\DepartmentController::class,'store'])->name('departments.store');
    //EDIT Department
    Route::get('Department/{id}/edit',[App\Http\Controllers\DepartmentController::class,'edit'])->name('departments.edit');
    Route::put('Department/{id}/edit',[App\Http\Controllers\DepartmentController::class,'update'])->name('departments.update');
    //DELETE Department
    Route::delete('Department/{id}/delete',[App\Http\Controllers\DepartmentController::class,'destroy'])->name('departments.destroy');
    //Import Excel
    Route::get('Department/import',[App\Http\Controllers\DepartmentController::class,'import'])->name('departments.import');
    Route::post('Department/import',[App\Http\Controllers\DepartmentController::class,'importExcelData'])->name('departments.importExcelData');
    //for Export Excel
    Route::get('Department/export', [App\Http\Controllers\DepartmentController::class, 'export'])->name('departments.export');

    // READ User Management
    Route::get('User', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    // CREATE User
    Route::get('User/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('User/create', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    // EDIT User
    Route::get('User/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('User/{id}/edit', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    // DELETE User
    Route::delete('User/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    //for Export Excel
    Route::get('User/export', [App\Http\Controllers\UserController::class, 'export'])->name('users.export');

    
    // READ Staff Management
    Route::get('Staff', [App\Http\Controllers\StaffController::class, 'index'])->name('staffs.index');
    // CREATE User
    Route::get('Staff/create', [App\Http\Controllers\StaffController::class, 'create'])->name('staffs.create');
    Route::post('Staff/create', [App\Http\Controllers\StaffController::class, 'store'])->name('staffs.store');
    // EDIT User
    Route::get('Staff/{id}/edit', [App\Http\Controllers\StaffController::class, 'edit'])->name('staffs.edit');
    Route::put('Staff/{id}/edit', [App\Http\Controllers\StaffController::class, 'update'])->name('staffs.update');
    // DELETE User
    Route::delete('Staff/{id}', [App\Http\Controllers\StaffController::class, 'destroy'])->name('staffs.destroy');
    //Import Excel
    Route::get('Staff/import',[App\Http\Controllers\StaffController::class,'import'])->name('staffs.import');
        Route::post('Staff/import',[App\Http\Controllers\StaffController::class,'importExcelData'])->name('staffs.importExcelData');
    //for Export Excel
    Route::get('Staff/export', [App\Http\Controllers\StaffController::class, 'export'])->name('staffs.export');


    //History
        // Loan Read
        Route::get('Loan', [App\Http\Controllers\LoanHistoryController::class, 'index'])->name('loans.index');
        // CREATE Loan
        Route::get('Loan/create', [App\Http\Controllers\LoanHistoryController::class, 'create'])->name('loans.create');
        Route::post('Loan/create', [App\Http\Controllers\LoanHistoryController::class, 'store'])->name('loans.store');
        // EDIT Loan
        Route::get('Loan/{id}/edit', [App\Http\Controllers\LoanHistoryController::class, 'edit'])->name('loans.edit');
        Route::put('Loan/{id}/edit', [App\Http\Controllers\LoanHistoryController::class, 'update'])->name('loans.update');
        // DELETE Loan
        Route::delete('Loan/{id}/delete', [App\Http\Controllers\LoanHistoryController::class, 'destroy'])->name('loans.destroy');
        // // Import Excel
        Route::get('Loan/import',[App\Http\Controllers\LoanHistoryController::class,'import'])->name('loans.import');
        Route::post('Loan/import',[App\Http\Controllers\LoanHistoryController::class,'importExcelData'])->name('loans.importExcelData');
        //for Export Excel
        Route::get('Loan/export', [App\Http\Controllers\LoanHistoryController::class, 'export'])->name('loans.export');

        
         //Available Read
        Route::get('Available', [App\Http\Controllers\AvailableHistoryController::class, 'index'])->name('availables.index');
        // CREATE Available
        Route::get('Available/create', [App\Http\Controllers\AvailableHistoryController::class, 'create'])->name('availables.create');
        Route::post('Available/create', [App\Http\Controllers\AvailableHistoryController::class, 'store'])->name('availables.store');
        // EDIT Available
        Route::get('Available/{id}/edit', [App\Http\Controllers\AvailableHistoryController::class, 'edit'])->name('availables.edit');
        Route::put('Available/{id}/edit', [App\Http\Controllers\AvailableHistoryController::class, 'update'])->name('availables.update');
        // DELETE Available
        Route::delete('Available/{id}', [App\Http\Controllers\AvailableHistoryController::class, 'destroy'])->name('availables.destroy');
        // // Import Excel
        Route::get('Available/import',[App\Http\Controllers\AvailableHistoryController::class,'import'])->name('availables.import');
        Route::post('Available/import',[App\Http\Controllers\AvailableHistoryController::class,'importExcelData'])->name('availables.importExcelData');
        //for Export Excel
        Route::get('Available/export', [App\Http\Controllers\AvailableHistoryController::class, 'export'])->name('availables.export');


        // //Disposal Read
        Route::get('Disposal', [App\Http\Controllers\DisposalHistoryController::class, 'index'])->name('disposals.index');
        // // CREATE Disposal
        Route::get('Disposal/create', [App\Http\Controllers\DisposalHistoryController::class, 'create'])->name('disposals.create');
        Route::post('Disposal/create', [App\Http\Controllers\DisposalHistoryController::class, 'store'])->name('disposals.store');
        // // EDIT Disposal
        Route::get('Disposal/{id}/edit', [App\Http\Controllers\DisposalHistoryController::class, 'edit'])->name('disposals.edit');
        Route::put('Disposal/{id}/edit', [App\Http\Controllers\DisposalHistoryController::class, 'update'])->name('disposals.update');
        // // DELETE Disposal
        Route::delete('Disposal/{id}', [App\Http\Controllers\DisposalHistoryController::class, 'destroy'])->name('disposals.destroy');
        // // Import Excel
        Route::get('Disposal/import',[App\Http\Controllers\DisposalHistoryController::class,'import'])->name('disposals.import');
        Route::post('Disposal/import',[App\Http\Controllers\DisposalHistoryController::class,'importExcelData'])->name('disposals.importExcelData');
        //for Export Excel
        Route::get('Disposal/export', [App\Http\Controllers\DisposalHistoryController::class, 'export'])->name('disposals.export');
        Route::resource('disposal-statuses', DisposalStatusController::class);


});

Route::middleware(['role:1,2,3'])->group(function () {
    // Routes for SuperAdmin and Admin
    //for asset count
    // Route::get('/dashboard', [App\Http\Controllers\AssetController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/assets', [AssetController::class, 'index']);

    //READ Asset
    Route::get('Asset',[App\Http\Controllers\AssetController::class, 'index'])->name('assets.index');
    //CREATE Asset
    Route::get('Asset/create',[App\Http\Controllers\AssetController::class,'create'])->name('assets.create');
    Route::post('Asset/create',[App\Http\Controllers\AssetController::class,'store'])->name('assets.store');
    //EDIT Asset
    Route::get('Asset/{id}/edit',[App\Http\Controllers\AssetController::class,'edit'])->name('assets.edit');
    Route::put('Asset/{id}/edit',[App\Http\Controllers\AssetController::class,'update'])->name('assets.update');
    //DELETE Asset
    Route::delete('Asset/{id}',[App\Http\Controllers\AssetController::class,'destroy'])->name('assets.destroy');

    //for import Excel
    Route::get('Asset/import',[App\Http\Controllers\AssetController::class,'import'])->name('assets.import');
    Route::post('Asset/import',[App\Http\Controllers\AssetController::class,'importExcelData'])->name('assets.importExcelData');

    //for Export Excel
    Route::get('Asset/export', [App\Http\Controllers\AssetController::class, 'export'])->name('assets.export');

    //For QR Code
    // Show QR Code
    Route::get('Asset/{id}/qr-code', [App\Http\Controllers\AssetController::class, 'showQrCode'])->name('assets.qrCode');
    Route::get('Asset/{id}/qr-code/download', [AssetController::class, 'generateQrCode'])->name('assets.qr-code.download');
    // Asset Details Page 
    Route::get('Asset/{id}/details', [App\Http\Controllers\AssetController::class, 'details'])->name('assets.details');

});




// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
