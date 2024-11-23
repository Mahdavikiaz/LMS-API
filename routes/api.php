<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LearningMaterialController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Middleware\InstructorOnly;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::aliasMiddleware('instructor', InstructorOnly::class);
Route::aliasMiddleware('admin', AdminMiddleware::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // routes untuk course
    Route::apiResource('courses', CourseController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    // routes untuk course
    Route::apiResource('courses', CourseController::class)->only('index');

    // routes untuk enrollment
    Route::apiResource('enrollments', EnrollmentController::class)->only(['index', 'store', 'destroy']);
});

Route::middleware(['auth:sanctum', 'instructor'])->group(function () {
    Route::post('/courses/{courseId}/materials', [LearningMaterialController::class, 'addMaterial']);
    Route::apiResource('quizzes', QuizController::class);
    Route::apiResource('questions', QuestionController::class);
});

Route::get('/courses/{courseId}/materials', [LearningMaterialController::class, 'getMaterialsByCourse']);
