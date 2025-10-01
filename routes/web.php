<?php


use App\Http\Controllers\DataTableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceLocationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\EmployeeCareerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeAttendanceLocationController;
use App\Http\Controllers\EmployeeBankAccountController;
use App\Http\Controllers\EmployeeLeaveBalanceController;
use App\Http\Controllers\EmployeeLeaveHistoryController;
use App\Http\Controllers\EmployeePayrollController;
use App\Http\Controllers\EmployeePaySlipController;
use App\Http\Controllers\EmployeeShiftController;
use App\Http\Controllers\EmployeeShiftGroupController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LimitDateController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MassLeaveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\OvertimeSalaryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ShiftDailyController;
use App\Http\Controllers\ShiftGroupController;
use App\Http\Controllers\ShiftGroupDetailController;
use App\Http\Controllers\UserController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [LoginController::class, 'reset'])->name('password.update');

Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/download/{filename}', function ($filename) {
        $file = storage_path('app/public/' . $filename);
        return response()->download($file);
    })->name('download');


    //user
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');


    //announcement
    Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement');
    Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('announcement/store', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::get('/announcement/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcement.edit');
    Route::get('/announcement/{id}/show', [AnnouncementController::class, 'show'])->name('announcement.show');
    Route::put('/announcement/{id}/update', [AnnouncementController::class, 'update'])->name('announcement.update');
    Route::delete('/announcement/{id}/delete', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');

    //attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::get('/attendance/{id}/show', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::put('/attendance/{id}/update', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{id}/delete', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
    Route::post('/attendance/export', [AttendanceController::class, 'report_process'])->name('attendance.export');

    //attendance_location
    Route::get('/attendance-location', [AttendanceLocationController::class, 'index'])->name('attendance_location');
    Route::get('/attendance-location/create', [AttendanceLocationController::class, 'create'])->name('attendance_location.create');
    Route::post('/attendance-location/store', [AttendanceLocationController::class, 'store'])->name('attendance_location.store');
    Route::get('/attendance-location/{id}/edit', [AttendanceLocationController::class, 'edit'])->name('attendance_location.edit');
    Route::get('/attendance-location/{id}/show', [AttendanceLocationController::class, 'show'])->name('attendance_location.show');
    Route::put('/attendance-location/{id}/update', [AttendanceLocationController::class, 'update'])->name('attendance_location.update');
    Route::delete('/attendance-location/{id}/delete', [AttendanceLocationController::class, 'destroy'])->name('attendance_location.destroy');

    //company
    Route::get('/company', [CompanyController::class, 'index'])->name('company');
    Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/company/store', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/company/{id}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::get('/company/{id}/show', [CompanyController::class, 'show'])->name('company.show');
    Route::put('/company/{id}/update', [CompanyController::class, 'update'])->name('company.update');
    Route::delete('/company/{id}/delete', [CompanyController::class, 'destroy'])->name('company.destroy');
    Route::post('/company/select', [CompanyController::class, 'select'])->name('company.select');

    //deduction
    Route::get('/deduction', [DeductionController::class, 'index'])->name('deduction');
    Route::get('/deduction/create', [DeductionController::class, 'create'])->name('deduction.create');
    Route::post('deduction/store', [DeductionController::class, 'store'])->name('deduction.store');
    Route::get('/deduction/{id}/edit', [DeductionController::class, 'edit'])->name('deduction.edit');
    Route::get('/deduction/{id}/show', [DeductionController::class, 'show'])->name('deduction.show');
    Route::put('/deduction/{id}/update', [DeductionController::class, 'update'])->name('deduction.update');
    Route::delete('/deduction/{id}/delete', [DeductionController::class, 'destroy'])->name('deduction.destroy');

    //division
    Route::get('/division', [DivisionController::class, 'index'])->name('division');
    Route::get('/division/create', [DivisionController::class, 'create'])->name('division.create');
    Route::post('division/store', [DivisionController::class, 'store'])->name('division.store');
    Route::get('/division/{id}/edit', [DivisionController::class, 'edit'])->name('division.edit');
    Route::get('/division/{id}/show', [DivisionController::class, 'show'])->name('division.show');
    Route::put('/division/{id}/update', [DivisionController::class, 'update'])->name('division.update');
    Route::delete('/division/{id}/delete', [DivisionController::class, 'destroy'])->name('division.destroy');

    //deduction
    Route::get('/earning', [EarningController::class, 'index'])->name('earning');
    Route::get('/earning/create', [EarningController::class, 'create'])->name('earning.create');
    Route::post('earning/store', [EarningController::class, 'store'])->name('earning.store');
    Route::get('/earning/{id}/edit', [EarningController::class, 'edit'])->name('earning.edit');
    Route::get('/earning/{id}/show', [EarningController::class, 'show'])->name('earning.show');
    Route::put('/earning/{id}/update', [EarningController::class, 'update'])->name('earning.update');
    Route::delete('/earning/{id}/delete', [EarningController::class, 'destroy'])->name('earning.destroy');

    //employee_career
    Route::get('/employee-career', [EmployeeCareerController::class, 'index'])->name('employee_career');
    Route::get('/employee-career/create', [EmployeeCareerController::class, 'create'])->name('employee_career.create');
    Route::post('/employee-career/store', [EmployeeCareerController::class, 'store'])->name('employee_career.store');
    Route::get('/employee-career/{id}/edit', [EmployeeCareerController::class, 'edit'])->name('employee_career.edit');
    Route::get('/employee-career/{id}/show', [EmployeeCareerController::class, 'show'])->name('employee_career.show');
    Route::put('/employee-career/{id}/update', [EmployeeCareerController::class, 'update'])->name('employee_career.update');
    Route::delete('/employee-career/{id}/delete', [EmployeeCareerController::class, 'destroy'])->name('employee_career.destroy');

    //employee
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::get('/employee/{id}/show', [EmployeeController::class, 'show'])->name('employee.show');
    Route::put('/employee/{id}/update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{id}/delete', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::post('/employee/import', [EmployeeController::class, 'import'])->name('employee.import');
    Route::get('/employee/change-list', [EmployeeController::class, 'changeList'])->name('employee.change_list');
    Route::get('/employee/change/{id}', [EmployeeController::class, 'change'])->name('employee.change');
    Route::post('/employee/change/{id}/approval', [EmployeeController::class, 'changeApproval'])->name('employee.change_approval');

    //employee_attendance_location
    Route::get('/employee-attendance-location', [EmployeeAttendanceLocationController::class, 'index'])->name('employee_attendance_location');
    Route::get('/employee-attendance-location/create', [EmployeeAttendanceLocationController::class, 'create'])->name('employee_attendance_location.create');
    Route::post('/employee-attendance-location/store', [EmployeeAttendanceLocationController::class, 'store'])->name('employee_attendance_location.store');
    Route::get('/employee-attendance-location/{id}/edit', [EmployeeAttendanceLocationController::class, 'edit'])->name('employee_attendance_location.edit');
    Route::get('/employee-attendance-location/{id}/show', [EmployeeAttendanceLocationController::class, 'show'])->name('employee_attendance_location.show');
    Route::put('/employee-attendance-location/{id}/update', [EmployeeAttendanceLocationController::class, 'update'])->name('employee_attendance_location.update');
    Route::delete('/employee-attendance-location/{id}/delete', [EmployeeAttendanceLocationController::class, 'destroy'])->name('employee_attendance_location.destroy');

    //employee_bank_account
    Route::get('/employee-bank-account', [EmployeeBankAccountController::class, 'index'])->name('employee_bank_account');
    Route::get('/employee-bank-account/create', [EmployeeBankAccountController::class, 'create'])->name('employee_bank_account.create');
    Route::post('employee-bank-account/store', [EmployeeBankAccountController::class, 'store'])->name('employee_bank_account.store');
    Route::get('/employee-bank-account/{id}/edit', [EmployeeBankAccountController::class, 'edit'])->name('employee_bank_account.edit');
    Route::get('/employee-bank-account/{id}/show', [EmployeeBankAccountController::class, 'show'])->name('employee_bank_account.show');
    Route::put('/employee-bank-account/{id}/update', [EmployeeBankAccountController::class, 'update'])->name('employee_bank_account.update');
    Route::delete('/employee-bank-account/{id}/delete', [EmployeeBankAccountController::class, 'destroy'])->name('employee_bank_account.destroy');

    //employee_leave_balance
    Route::get('/employee-leave-balance', [EmployeeLeaveBalanceController::class, 'index'])->name('employee_leave_balance');
    Route::get('/employee-leave-balance/create', [EmployeeLeaveBalanceController::class, 'create'])->name('employee_leave_balance.create');
    Route::post('/employee-leave-balance/store', [EmployeeLeaveBalanceController::class, 'store'])->name('employee_leave_balance.store');
    Route::get('/employee-leave-balance/{id}/edit', [EmployeeLeaveBalanceController::class, 'edit'])->name('employee_leave_balance.edit');
    Route::get('/employee-leave-balance/{id}/show', [EmployeeLeaveBalanceController::class, 'show'])->name('employee_leave_balance.show');
    Route::put('/employee-leave-balance/{id}/update', [EmployeeLeaveBalanceController::class, 'update'])->name('employee_leave_balance.update');
    Route::delete('/employee-leave-balance/{id}/delete', [EmployeeLeaveBalanceController::class, 'destroy'])->name('employee_leave_balance.destroy');

    //employee_leave_history
    Route::get('/employee-leave-history', [EmployeeLeaveHistoryController::class, 'index'])->name('employee_leave_history');
    Route::get('/employee-leave-history/create', [EmployeeLeaveHistoryController::class, 'create'])->name('employee_leave_history.create');
    Route::post('/employee-leave-history/store', [EmployeeLeaveHistoryController::class, 'store'])->name('employee_leave_history.store');
    Route::get('/employee-leave-history/{id}/edit', [EmployeeLeaveHistoryController::class, 'edit'])->name('employee_leave_history.edit');
    Route::get('/employee-leave-history/{id}/show', [EmployeeLeaveHistoryController::class, 'show'])->name('employee_leave_history.show');
    Route::put('/employee-leave-history/{id}/update', [EmployeeLeaveHistoryController::class, 'update'])->name('employee_leave_history.update');
    Route::delete('/employee-leave-history/{id}/delete', [EmployeeLeaveHistoryController::class, 'destroy'])->name('employee_leave_history.destroy');
    Route::get('/employee-leave-history/{id}/approve', [EmployeeLeaveHistoryController::class, 'approve'])->name('employee_leave_history.approve');
    Route::post('/employee-leave-history/{id}/reject', [EmployeeLeaveHistoryController::class, 'reject'])->name('employee_leave_history.reject');

    //employee_payroll
    Route::get('/employee-payroll', [EmployeePayrollController::class, 'index'])->name('employee_payroll');
    Route::get('/employee-payroll/create', [EmployeePayrollController::class, 'create'])->name('employee_payroll.create');
    Route::post('/employee-payroll/store', [EmployeePayrollController::class, 'store'])->name('employee_payroll.store');
    Route::get('/employee-payroll/{id}/edit', [EmployeePayrollController::class, 'edit'])->name('employee_payroll.edit');
    Route::get('/employee-payroll/{id}/show', [EmployeePayrollController::class, 'show'])->name('employee_payroll.show');
    Route::put('/employee-payroll/{id}/update', [EmployeePayrollController::class, 'update'])->name('employee_payroll.update');
    Route::delete('/employee-payroll/{id}/delete', [EmployeePayrollController::class, 'destroy'])->name('employee_payroll.destroy');
    Route::get('/employee-payroll/export-preview', [EmployeePayrollController::class, 'preview'])->name('employee-payroll.preview');
    Route::get('/employee-payroll/export', [EmployeePayrollController::class, 'export'])->name('employee-payroll.export');

    //employee_shift
    Route::get('/employee-shift', [EmployeeShiftController::class, 'index'])->name('employee_shift');
    Route::get('/employee-shift/create', [EmployeeShiftController::class, 'create'])->name('employee_shift.create');
    Route::post('/employee-shift/store', [EmployeeShiftController::class, 'store'])->name('employee_shift.store');
    Route::get('/employee-shift/{id}/edit', [EmployeeShiftController::class, 'edit'])->name('employee_shift.edit');
    Route::get('/employee-shift/{id}/show', [EmployeeShiftController::class, 'show'])->name('employee_shift.show');
    Route::put('/employee-shift/{id}/update', [EmployeeShiftController::class, 'update'])->name('employee_shift.update');
    Route::delete('/employee-shift/{id}/delete', [EmployeeShiftController::class, 'destroy'])->name('employee_shift.destroy');
    Route::post('/employee-shift/import', [EmployeeShiftController::class, 'import'])->name('employee_shift.import');

    //employee_shift_group
    Route::get('/employee-shift-group', [EmployeeShiftGroupController::class, 'index'])->name('employee_shift_group');
    Route::get('/employee-shift-group/create', [EmployeeShiftGroupController::class, 'create'])->name('employee_shift_group.create');
    Route::post('/employee-shift-group/store', [EmployeeShiftGroupController::class, 'store'])->name('employee_shift_group.store');
    Route::get('/employee-shift-group/{id}/edit', [EmployeeShiftGroupController::class, 'edit'])->name('employee_shift_group.edit');
    Route::get('/employee-shift-group/{id}/show', [EmployeeShiftGroupController::class, 'show'])->name('employee_shift_group.show');
    Route::put('/employee-shift-group/{id}/update', [EmployeeShiftGroupController::class, 'update'])->name('employee_shift_group.update');
    Route::delete('/employee-shift-group/{id}/delete', [EmployeeShiftGroupController::class, 'destroy'])->name('employee_shift_group.destroy');

    //holiday
    Route::get('/holiday', [HolidayController::class, 'index'])->name('holiday');
    Route::get('/holiday/create', [HolidayController::class, 'create'])->name('holiday.create');
    Route::post('/holiday/store', [HolidayController::class, 'store'])->name('holiday.store');
    Route::get('/holiday/{id}/edit', [HolidayController::class, 'edit'])->name('holiday.edit');
    Route::get('/holiday/{id}/show', [HolidayController::class, 'show'])->name('holiday.show');
    Route::put('/holiday/{id}/update', [HolidayController::class, 'update'])->name('holiday.update');
    Route::delete('/holiday/{id}/delete', [HolidayController::class, 'destroy'])->name('holiday.destroy');

    //leave_type
    Route::get('/leave-type', [LeaveTypeController::class, 'index'])->name('leave_type');
    Route::get('/leave-type/create', [LeaveTypeController::class, 'create'])->name('leave_type.create');
    Route::post('/leave-type/store', [LeaveTypeController::class, 'store'])->name('leave_type.store');
    Route::get('/leave-type/{id}/edit', [LeaveTypeController::class, 'edit'])->name('leave_type.edit');
    Route::get('/leave-type/{id}/show', [LeaveTypeController::class, 'show'])->name('leave_type.show');
    Route::put('/leave-type/{id}/update', [LeaveTypeController::class, 'update'])->name('leave_type.update');
    Route::delete('/leave-type/{id}/delete', [LeaveTypeController::class, 'destroy'])->name('leave_type.destroy');

    //limit_date
    Route::get('/limit-date', [LimitDateController::class, 'index'])->name('limit_date');
    Route::get('/limit-date/create', [LimitDateController::class, 'create'])->name('limit_date.create');
    Route::post('/limit-date/store', [LimitDateController::class, 'store'])->name('limit_date.store');
    Route::get('/limit-date/{id}/edit', [LimitDateController::class, 'edit'])->name('limit_date.edit');
    Route::get('/limit-date/{id}/show', [LimitDateController::class, 'show'])->name('limit_date.show');
    Route::put('/limit-date/{id}/update', [LimitDateController::class, 'update'])->name('limit_date.update');
    Route::delete('/limit-date/{id}/delete', [LimitDateController::class, 'destroy'])->name('limit_date.destroy');

    //mass_leave
    Route::get('/mass-leave', [MassLeaveController::class, 'index'])->name('mass_leave');
    Route::get('/mass-leave/create', [MassLeaveController::class, 'create'])->name('mass_leave.create');
    Route::post('/mass-leave/store', [MassLeaveController::class, 'store'])->name('mass_leave.store');
    Route::get('/mass-leave/{id}/edit', [MassLeaveController::class, 'edit'])->name('mass_leave.edit');
    Route::get('/mass-leave/{id}/show', [MassLeaveController::class, 'show'])->name('mass_leave.show');
    Route::put('/mass-leave/{id}/update', [MassLeaveController::class, 'update'])->name('mass_leave.update');
    Route::delete('/mass-leave/{id}/delete', [MassLeaveController::class, 'destroy'])->name('mass_leave.destroy');

    //notification
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
    Route::get('/notification/create', [NotificationController::class, 'create'])->name('notification.create');
    Route::post('/notification/store', [NotificationController::class, 'store'])->name('notification.store');
    Route::get('/notification/{id}/edit', [NotificationController::class, 'edit'])->name('notification.edit');
    Route::get('/notification/{id}/show', [NotificationController::class, 'show'])->name('notification.show');
    Route::put('/notification/{id}/update', [NotificationController::class, 'update'])->name('notification.update');
    Route::delete('/notification/{id}/delete', [NotificationController::class, 'destroy'])->name('notification.destroy');

    //overtime
    Route::get('/overtime', [OvertimeController::class, 'index'])->name('overtime');
    Route::get('/overtime/create', [OvertimeController::class, 'create'])->name('overtime.create');
    Route::post('/overtime/store', [OvertimeController::class, 'store'])->name('overtime.store');
    Route::get('/overtime/{id}/edit', [OvertimeController::class, 'edit'])->name('overtime.edit');
    Route::get('/overtime/{id}/show', [OvertimeController::class, 'show'])->name('overtime.show');
    Route::put('/overtime/{id}/update', [OvertimeController::class, 'update'])->name('overtime.update');
    Route::delete('/overtime/{id}/delete', [OvertimeController::class, 'destroy'])->name('overtime.destroy');
    Route::get('/overtime/export-preview', [OvertimeController::class, 'preview'])->name('overtime.preview');
    Route::get('/overtime/export', [OvertimeController::class, 'export'])->name('overtime.export');
    Route::get('/overtime/{id}/approve', [OvertimeController::class, 'approve'])->name('overtime.approve');
    Route::post('/overtime/{id}/reject', [OvertimeController::class, 'reject'])->name('overtime.reject');


    //overtime_salary
    Route::get('/overtime-salary', [OvertimeSalaryController::class, 'index'])->name('overtime_salary');
    Route::get('/overtime-salary/create', [OvertimeSalaryController::class, 'create'])->name('overtime_salary.create');
    Route::post('/overtime-salary/store', [OvertimeSalaryController::class, 'store'])->name('overtime_salary.store');
    Route::get('/overtime-salary/{id}/edit', [OvertimeSalaryController::class, 'edit'])->name('overtime_salary.edit');
    Route::get('/overtime-salary/{id}/show', [OvertimeSalaryController::class, 'show'])->name('overtime_salary.show');
    Route::put('/overtime-salary/{id}/update', [OvertimeSalaryController::class, 'update'])->name('overtime_salary.update');
    Route::delete('/overtime-salary/{id}/delete', [OvertimeSalaryController::class, 'destroy'])->name('overtime_salary.destroy');

    //position
    Route::get('/position', [PositionController::class, 'index'])->name('position');
    Route::get('/position/create', [PositionController::class, 'create'])->name('position.create');
    Route::post('position/store', [PositionController::class, 'store'])->name('position.store');
    Route::get('/position/{id}/edit', [PositionController::class, 'edit'])->name('position.edit');
    Route::get('/position/{id}/show', [PositionController::class, 'show'])->name('position.show');
    Route::put('/position/{id}/update', [PositionController::class, 'update'])->name('position.update');
    Route::delete('/position/{id}/delete', [PositionController::class, 'destroy'])->name('position.destroy');

    //shift_daily
    Route::get('/shift-daily', [ShiftDailyController::class, 'index'])->name('shift_daily');
    Route::get('/shift-daily/create', [ShiftDailyController::class, 'create'])->name('shift_daily.create');
    Route::post('/shift-daily/store', [ShiftDailyController::class, 'store'])->name('shift_daily.store');
    Route::get('/shift-daily/{id}/edit', [ShiftDailyController::class, 'edit'])->name('shift_daily.edit');
    Route::get('/shift-daily/{id}/show', [ShiftDailyController::class, 'show'])->name('shift_daily.show');
    Route::put('/shift-daily/{id}/update', [ShiftDailyController::class, 'update'])->name('shift_daily.update');
    Route::delete('/shift-daily/{id}/delete', [ShiftDailyController::class, 'destroy'])->name('shift_daily.destroy');

    //shift_group
    Route::get('/shift-group', [ShiftGroupController::class, 'index'])->name('shift_group');
    Route::get('/shift-group/create', [ShiftGroupController::class, 'create'])->name('shift_group.create');
    Route::post('/shift-group/store', [ShiftGroupController::class, 'store'])->name('shift_group.store');
    Route::get('/shift-group/{id}/edit', [ShiftGroupController::class, 'edit'])->name('shift_group.edit');
    Route::get('/shift-group/{id}/show', [ShiftGroupController::class, 'show'])->name('shift_group.show');
    Route::put('/shift-group/{id}/update', [ShiftGroupController::class, 'update'])->name('shift_group.update');
    Route::delete('/shift-group/{id}/delete', [ShiftGroupController::class, 'destroy'])->name('shift_group.destroy');

    //shift_group_detail
    Route::get('/shift-group-detail', [ShiftGroupDetailController::class, 'index'])->name('shift_group_detail');
    Route::get('/shift-group-detail/create', [ShiftGroupDetailController::class, 'create'])->name('shift_group_detail.create');
    Route::post('/shift-group-detail/store', [ShiftGroupDetailController::class, 'store'])->name('shift_group_detail.store');
    Route::get('/shift-group-detail/{id}/edit', [ShiftGroupDetailController::class, 'edit'])->name('shift_group_detail.edit');
    Route::get('/shift-group-detail/{id}/show', [ShiftGroupDetailController::class, 'show'])->name('shift_group_detail.show');
    Route::put('/shift-group-detail/{id}/update', [ShiftGroupDetailController::class, 'update'])->name('shift_group_detail.update');
    Route::delete('/shift-group-detail/{id}/delete', [ShiftGroupDetailController::class, 'destroy'])->name('shift_group_detail.destroy');

    //kpi
    Route::get('/kpi', [KpiController::class, 'index'])->name('kpi');

    //log
    Route::get('/log', [LogController::class, 'index'])->name('log');

    Route::get('/clientside', [DataTableController::class, 'clientside'])->name('clientside');
    Route::get('/serverside', [DataTableController::class, 'serverside'])->name('serverside');

    //endovertime
    Route::group(
        ['prefix' => 'setting'],
        function () {
            Route::get('/time-and-attendance', function () {
                return view('setting.time_and_attendance');
            })->name('setting.time-and-attendance');
        }
    );
});

Route::group(['middleware' => ['auth', 'non_admin']], function () {
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::get('/employee/{id}/show', [EmployeeController::class, 'show'])->name('employee.show');
    Route::put('/employee/{id}/update', [EmployeeController::class, 'update'])->name('employee.update');

    Route::get('/employee-payslip', [EmployeePaySlipController::class, 'index'])->name('employee_payslip');
    Route::get('/employee-payslip/{id}/show', [EmployeePaySlipController::class, 'show'])->name('employee_payslip.show');
    Route::get('/employee-payslip/generate-pdf', [EmployeePaySlipController::class, 'generatePdf'])->name('employee_payslip.generate_pdf');

    Route::get('/dashboard', [HomeController::class, 'userIndex'])->name('dashboard');

    Route::get('/announcement/{id}/show', [AnnouncementController::class, 'show'])->name('announcement.show');

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::get('/attendance/current', [AttendanceController::class, 'getCurrent'])->name('attendance.current');
    Route::get('/attendance/{id}/checkin', [AttendanceController::class, 'checkin'])->name('attendance.checkin');
    Route::get('/attendance/{id}/checkout', [AttendanceController::class, 'checkout'])->name('attendance.checkout');
    Route::put('/attendance/{id}/checkin_process', [AttendanceController::class, 'checkin_process'])->name('attendance.checkin_process');
    Route::put('/attendance/{id}/checkout_process', [AttendanceController::class, 'checkout_process'])->name('attendance.checkout_process');

    Route::get('/employee-leave-balance', [EmployeeLeaveBalanceController::class, 'index'])->name('employee_leave_balance');

    Route::get('/employee-leave-history', [EmployeeLeaveHistoryController::class, 'index'])->name('employee_leave_history');

    Route::get('/notification/{id}/show', [NotificationController::class, 'show'])->name('notification.show');

    Route::get('/overtime', [OvertimeController::class, 'index'])->name('overtime');
    Route::get('/overtime/create', [OvertimeController::class, 'create'])->name('overtime.create');
    Route::post('/overtime/store', [OvertimeController::class, 'store'])->name('overtime.store');
    Route::get('/overtime/{id}/edit', [OvertimeController::class, 'edit'])->name('overtime.edit');
    Route::get('/overtime/{id}/show', [OvertimeController::class, 'show'])->name('overtime.show');
    Route::put('/overtime/{id}/update', [OvertimeController::class, 'update'])->name('overtime.update');
    Route::get('/overtime/payslip', [OvertimeController::class, 'slip_index'])->name('overtime.slip_index');
    Route::get('/overtime/payslip/{id}/show', [OvertimeController::class, 'slip_show'])->name('overtime.slip_show');
    Route::get('/overtime/payslip/{id}/generate-pdf', [OvertimeController::class, 'generatePdf'])->name('overtime.slip_pdf');
});

//attendance route
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
