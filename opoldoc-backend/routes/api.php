<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DoctorProfileController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PatientFileController;
use App\Http\Controllers\Api\PatientProfileController;
use App\Http\Controllers\Api\PatientStatusController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\PrescriptionItemController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisitController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('patient-profiles', PatientProfileController::class);
    Route::apiResource('doctor-profiles', DoctorProfileController::class);
    Route::apiResource('appointments', AppointmentController::class);
    Route::apiResource('visits', VisitController::class);
    Route::apiResource('patient-statuses', PatientStatusController::class);
    Route::apiResource('prescriptions', PrescriptionController::class);
    Route::apiResource('prescription-items', PrescriptionItemController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('notifications', NotificationController::class);
    Route::apiResource('files', PatientFileController::class);
    Route::apiResource('logs', AuditLogController::class);

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead']);
});
