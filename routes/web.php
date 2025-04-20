<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RABController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\JobDetailController;
use App\Http\Controllers\VolumeItemController;
use App\Http\Controllers\JobEmployeeController;
use App\Http\Controllers\JobMaterialController;
use App\Http\Controllers\JobEquipmentController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\ProgressReportController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::resource('projects', ProjectController::class);
Route::resource('houses', HouseController::class);
Route::resource('users', UserController::class);
Route::resource('expenses', ExpenseReportController::class);
Route::resource('progress', ProgressReportController::class);
Route::resource('rab', RABController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('equipments', EquipmentController::class);
Route::resource('materials', MaterialController::class);
Route::resource('jobs', JobController::class);
// Route::resource('volume', VolumeItemController::class);


// Route::prefix('jobs/{job}')->group(function () {
//     Route::get('detail', [JobDetailController::class, 'priceAnalysis'])->name('jobs.priceAnalysis');
//     Route::post('add-material', [JobDetailController::class, 'addMaterial'])->name('jobs.addMaterial');
//     Route::post('add-equipment', [JobDetailController::class, 'addEquipment'])->name('jobs.addEquipment');
//     Route::post('add-employee', [JobDetailController::class, 'addEmployee'])->name('jobs.addEmployee');
//     Route::patch('update-material/{material}', [JobDetailController::class, 'updateMaterial'])->name('jobs.updateMaterial');
//     Route::patch('update-equipment/{equipment}', [JobDetailController::class, 'updateEquipment'])->name('jobs.updateEquipment');
//     Route::patch('update-employee/{employee}', [JobDetailController::class, 'updateEmployee'])->name('jobs.updateEmployee');
// });

Route::prefix('jobs/{job_id}')->group(function () {
    Route::get('detail', [JobDetailController::class, 'priceAnalysis'])->name('jobs.priceAnalysis');
    Route::get('update-total-cost', [JobDetailController::class, 'updateTotalCost'])->name('jobs.updateTotalCost');

    // Bahan
    Route::get('materials/select', [JobMaterialController::class, 'select'])->name('job-materials.select');
    Route::post('materials/select', [JobMaterialController::class, 'storeSelected'])->name('job-materials.storeSelected');
    Route::delete('materials/{material_id}', [JobMaterialController::class, 'destroy'])->name('job-materials.destroy');
    Route::put('materials/{material_id}', [JobMaterialController::class, 'updateSingle'])->name('job-materials.updateSingle');

    // Alat
    Route::get('equipments/select', [JobEquipmentController::class, 'select'])->name('job-equipments.select');
    Route::post('equipments/select', [JobEquipmentController::class, 'storeSelected'])->name('job-equipments.storeSelected');
    Route::delete('equipments/{equipment_id}', [JobEquipmentController::class, 'destroy'])->name('job-equipments.destroy');
    Route::put('equipments/{equipment_id}', [JobEquipmentController::class, 'updateSingle'])->name('job-equipments.updateSingle');

    // Pekerja
    Route::get('employees/select', [JobEmployeeController::class, 'select'])->name('job-employees.select');
    Route::post('employees/select', [JobEmployeeController::class, 'storeSelected'])->name('job-employees.storeSelected');
    Route::delete('employees/{employee_id}', [JobEmployeeController::class, 'destroy'])->name('job-employees.destroy');
    Route::put('employees/{employee_id}', [JobEmployeeController::class, 'updateSingle'])->name('job-employees.updateSingle');
});

// // Alat
// Route::get('equipments/select', [JobEquipmentController::class, 'select'])->name('job-equipments.select');
// Route::post('equipments/select', [JobEquipmentController::class, 'storeSelected'])->name('job-equipments.storeSelected');
// Route::delete('equipments/{equipment_id}', [JobEquipmentController::class, 'destroy'])->name('job-equipments.destroy');

// // Pekerja
// Route::get('employees/select', [JobEmployeeController::class, 'select'])->name('job-employees.select');
// Route::post('employees/select', [JobEmployeeController::class, 'storeSelected'])->name('job-employees.storeSelected');
// Route::delete('employees/{employee_id}', [JobEmployeeController::class, 'destroy'])->name('job-employees.destroy');
// });

Route::prefix('jobs/{job}/volume')->group(function () {
    Route::get('/', [VolumeItemController::class, 'index'])->name('volume.index');
    Route::post('/', [VolumeItemController::class, 'store'])->name('volume.store');
    Route::delete('/{volume}', [VolumeItemController::class, 'destroy'])->name('volume.destroy');
    Route::put('/{volume}', [VolumeItemController::class, 'update'])->name('volume.update');
});

// Route::prefix('volume/{job_id}')->group(function () {
//     Route::get('/', [VolumeItemController::class, 'index'])->name('volume.index');
//     Route::post('/store', [VolumeItemController::class, 'store'])->name('volume.store');
//     Route::put('/update/{volume_id}', [VolumeItemController::class, 'update'])->name('volume.update');
//     Route::delete('/delete/{volume_id}', [VolumeItemController::class, 'destroy'])->name('volume.destroy');
// });
