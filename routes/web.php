<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnrollmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', function () {
    return view('home');
});

// =========================
// STUDENT FLOW
// =========================

// STEP 1
Route::get('/enroll', fn() => view('enroll'));

// STEP 2 (FORM)
Route::get('/step2', fn() => view('step2'));

// 🔥 STEP 2 SUBMIT (NEW)
Route::post('/step2/store', [EnrollmentController::class, 'storeStep2'])->name('step2.store');

// 🔥 STEP 3 (ONLY IF SESSION EXISTS)
Route::get('/step3', function () {
    if (!session()->has('enrollment')) {
        return redirect('/step2')->with('error', 'Please complete Step 2 first.');
    }
    return view('step3');
});

// FINAL SUBMIT
Route::post('/enroll/store', [EnrollmentController::class, 'store'])->name('enroll.store');

// FINISH
Route::get('/finish', fn() => view('finish'));


// =========================
// ADMIN (AUTH REQUIRED)
// =========================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/enrollees', [AdminController::class, 'enrollees']);
    Route::get('/students', [AdminController::class, 'students']);

    Route::post('/approve/{id}', [AdminController::class, 'approve']);
    
    Route::post('/delete/{id}', [AdminController::class, 'delete']);
    Route::post('/students/assign/{id}', [AdminController::class, 'assign']);
    Route::post('/students/update/{id}', [AdminController::class, 'updateStudent']);
    Route::get('/students/archive/{id}', [AdminController::class, 'archive']);
    
});


// =========================
// PROFILE (DEFAULT)
// =========================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';