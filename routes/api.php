<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeLeaveHistoryController;
use App\Http\Controllers\EmployeeShiftController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OvertimeController;
use App\Models\Announcement;
use App\Models\Employee;
use App\Models\EmployeeCareer;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login_api'])->name('login');
Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('forgot_password');
Route::get('/profile', [EmployeeController::class, 'get'])->name('profile');
Route::post('/profile/{id}', [EmployeeController::class, 'put'])->name('profile');

Route::get('/attendance', [AttendanceController::class, 'get'])->name('attendance.get');
Route::post('/attendance/{id}/checkin', [AttendanceController::class, 'checkInApi'])->name('attendance.checkin');
Route::post('/attendance/{id}/checkout', [AttendanceController::class, 'checkOutApi'])->name('attendance.checkout');
Route::post('/attendance/{id}', [AttendanceController::class, 'put'])->name('attendance.update');

Route::get('/overtime', [OvertimeController::class, 'get'])->name('overtime.get');
Route::post('/overtime/create', [OvertimeController::class, 'post'])->name('overtime.post');
Route::put('/overtime/{id}/update', [OvertimeController::class, 'put'])->name('overtime.put');
Route::get('/overtime/slip', [OvertimeController::class, 'slipList'])->name('overtime.slip_list');
Route::get('/overtime/slip/{id}', [OvertimeController::class, 'download'])->name('overtime.slip_download');

Route::get('/payslip', [OvertimeController::class, 'slipList'])->name('overtime.slip_list');
Route::get('/payslip/{id}', [OvertimeController::class, 'download'])->name('overtime.slip_download');

Route::get('/leave', [EmployeeLeaveHistoryController::class, 'get'])->name('attendance.get');
Route::post('/leave/create', [EmployeeLeaveHistoryController::class, 'post'])->name('attendance.post');
Route::put('/leave/{id}/update', [EmployeeLeaveHistoryController::class, 'put'])->name('attendance.put');

Route::get('/announcement', [AnnouncementController::class, 'get'])->name('announcement.get');
Route::get('/shift', [EmployeeShiftController::class, 'get'])->name('shift.get');
Route::get('/leave-type', [LeaveTypeController::class, 'get'])->name('leave-type.get');

Route::get('/current-shift', [AttendanceController::class, 'currentShift'])->name('shift.current');
Route::get('/monthly-shift', [AttendanceController::class, 'monthlyShift'])->name('shift.monthly');