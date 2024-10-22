<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ResponseController;

// Route::get('/', [ComplaintController::class, 'home']);
Route::get('/', [ComplaintController::class, 'dashboard'])->name('complaints.dashboard');
Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
Route::post('/complaints/store', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/responses', [ResponseController::class, 'index'])->name('response.index');
Route::get('/response/{id}/detail', [ResponseController::class, 'detail'])->name('response.detail');
Route::get('/responses/create/{id}', [ResponseController::class, 'create'])->name('responses.create');
Route::post('/responses/store', [ResponseController::class, 'store'])->name('responses.store');
Route::get('/responses/create/{complaint_id}', [ResponseController::class, 'create'])->name('responses.create');
Route::get('/my-complaints', [ResponseController::class, 'ourComplaints'])->name('our_complaints');
Route::get('/my-complaints/{id}', [ResponseController::class, 'ourResponse'])->name('our_response');
Route::delete('/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('complaints.destroy');
Route::get('response/search', [ResponseController::class, 'search'])->name('response.search');
Route::get('/complaints/search', [ComplaintController::class, 'search'])->name('complaints.search');

// Route::get('/', function () {
//     return view('admin.complaints');
// });

// Route::get('comp', function () {
//     return view('admin.complaints');
// });

// Route::get('admin.dashboard', function () {
//     return view('admin.complaints');
// })->name('admin.dashboard');

// Route::get('admin.complaint', function () {
//     return view('admin.complaints');
// })->name('admin.complaint');

// Route::get('admin.response', function () {
//     return view('admin.response');
// })->name('admin.response');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
