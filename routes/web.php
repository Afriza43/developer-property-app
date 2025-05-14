<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RABController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\SubJobController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\UnitReportController;
use App\Http\Controllers\VolumeItemController;
use App\Http\Controllers\JobEmployeeController;
use App\Http\Controllers\JobMaterialController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\JobEquipmentController;
use App\Http\Controllers\SubJobDetailController;
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
Route::resource('unit_reports', UnitReportController::class);
Route::resource('project-types', ProjectTypeController::class);


// routes/web.php
Route::post('/rab/{type_id}/update-budget-plan', [RabController::class, 'updateBudgetPlan'])->name('rab.updateBudgetPlan');


Route::prefix('jobs/{sub_job_id}')->group(function () {
    Route::get('detail', [SubJobDetailController::class, 'priceAnalysis'])->name('jobs.priceAnalysis');
    Route::get('update-total-cost', [SubJobDetailController::class, 'updateTotalCost'])->name('jobs.updateTotalCost');

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

Route::prefix('jobs/{sub_job_id}/volume')->group(function () {
    Route::get('/', [VolumeItemController::class, 'index'])->name('volume.index');
    Route::post('/', [VolumeItemController::class, 'store'])->name('volume.store');
    Route::delete('/{volume}', [VolumeItemController::class, 'destroy'])->name('volume.destroy');
    Route::put('/{volume}', [VolumeItemController::class, 'update'])->name('volume.update');
});

// Job Category
Route::get('categories/select/{type_id}', [CategoryController::class, 'selectJobCategory'])->name('categories.selectJobCategory');
Route::post('categories/select/{type_id}', [CategoryController::class, 'storeSelectedJobCategory'])->name('categories.storeSelectedJobCategory');
Route::delete('categories/select/{typeId}/{categoryId}', [CategoryController::class, 'destroySelectedJobCategory'])->name('categories.destroySelectedJobCategory');

Route::post('/categories/select/{type_id}/addJobCategory', [CategoryController::class, 'addJobCategory'])->name('categories.addJobCategory');
Route::put('/categories/updateJobCategory/{category_id}', [CategoryController::class, 'updateJobCategory'])->name('categories.updateJobCategory');

// Routes untuk pemilihan dan pengelolaan job
Route::get('/jobs/select/{jobtype_id}', [SubJobController::class, 'selectJob'])->name('jobs.selectJob');
Route::post('/jobs/select/{jobtype_id}/store', [SubJobController::class, 'storeSelectedJob'])->name('jobs.storeSelectedJob');
Route::delete('/jobs/select/{jobtype_id}/destroy/{job_id}', [SubJobController::class, 'destroySelectedJob'])->name('jobs.destroySelectedJob');

Route::post('/jobs/select/{jobtype_id}/addJob', [SubJobController::class, 'addJob'])->name('jobs.addJob');
Route::put('/jobs/updateJob/{job_id}', [SubJobController::class, 'updateJob'])->name('jobs.updateJob');
