<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CvController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/updatepersonaldata', [CvController::class, 'updatePersonalData'])->name('personal.data');
    Route::get('/viewcv', [CvController::class, 'createPdfCv'])->name('view.cv');
    Route::get('/viewcv2', [CvController::class, 'view2'])->name('view2.cv');
    Route::get('/mis-cvs', [CvController::class, 'viewCvs'])->name('miscvs');
    Route::get('/new-cv', [CvController::class, 'createNewCv'])->name('createnewcv');
    Route::post('/savenewcv', [CvController::class, 'saveNewCv'])->name('savenewcv');
    Route::get('/editcv/{id}', [CvController::class, 'editCv'])->name('editcv');
    Route::put('/editcv/', [CvController::class, 'updateCv'])->name('updatecv');
    Route::post('/editcv/addexperience/', [CvController::class, 'addExperience'])->name('addexperience');
    Route::post('/editcv/updateexperience/', [CvController::class, 'updateExperience'])->name('updateexperience');
    Route::delete('/editcv/deleteexperience/{id}', [CvController::class, 'deleteExperience'])->name('deleteexperience');

    Route::post('/editcv/addformation/', [CvController::class, 'addFormation'])->name('addformation');
    Route::post('/editcv/updateformation/', [CvController::class, 'updateFormation'])->name('updateformation');
    Route::delete('/editcv/deleteformation/{id}', [CvController::class, 'deleteFormation'])->name('deleteformation');

    Route::post('/editcv/addskill/', [CvController::class, 'addSkill'])->name('addskill');
    Route::post('/editcv/updateskill/', [CvController::class, 'updateSkill'])->name('updateskill');
    Route::delete('/editcv/deleteskill/{id}', [CvController::class, 'deleteSkill'])->name('deleteskill');

});



require __DIR__.'/auth.php';
