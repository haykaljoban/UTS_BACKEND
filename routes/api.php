<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    
    # Get all resource patients
    # Method GET
    Route::get('/patients', [PatientController::class, 'index']);

    # Get specific patients
    # Method GET
    Route::get('/patients/{id}', [PatientController::class, 'show']);

    # Search patients by name
    # Method GET
    Route::get('/patients/search/{name}', [PatientController::class, 'search']);

    # Get patients with positive status
    # Method GET
    Route::get('/patients/status/positive', [PatientController::class, 'positive']);

    # Get patients with recovered status
    # Method GET
    Route::get('/patients/status/recovered', [PatientController::class, 'recovered']);

    # Get patients with dead status
    # Method GET
    Route::get('/patients/status/dead', [PatientController::class, 'dead']);

    # Add resource patients
    # Method POST
    Route::post('/patients', [PatientController::class, 'store']);

    # Edit resource patients
    # Method PUT
    Route::put('/patients/{id}', [PatientController::class, 'update']);

    # Delete resource patients
    # Method DELETE
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

    # Make route for Register and Login
    Route::post('/patients/register', [AuthController::class, 'register']);
    Route::post('/patients/login', [AuthController::class, 'login']);
});