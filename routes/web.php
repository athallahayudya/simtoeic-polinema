<?php

use App\Http\Controllers\AlumniController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StaffController;
use App\Models\StudentModel;
use App\Http\Controllers\AdminProfileController;
use App\Models\UserModel;

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


// Layout
Route::get('/layout-default-layout', function () {
    return view('pages.layout-default-layout', ['type_menu' => 'layout']);
});

// Bootstrap
Route::get('/bootstrap-alert', function () {
    return view('pages.bootstrap-alert', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-badge', function () {
    return view('pages.bootstrap-badge', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-breadcrumb', function () {
    return view('pages.bootstrap-breadcrumb', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-buttons', function () {
    return view('pages.bootstrap-buttons', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-card', function () {
    return view('pages.bootstrap-card', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-carousel', function () {
    return view('pages.bootstrap-carousel', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-collapse', function () {
    return view('pages.bootstrap-collapse', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-dropdown', function () {
    return view('pages.bootstrap-dropdown', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-form', function () {
    return view('pages.bootstrap-form', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-list-group', function () {
    return view('pages.bootstrap-list-group', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-media-object', function () {
    return view('pages.bootstrap-media-object', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-modal', function () {
    return view('pages.bootstrap-modal', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-nav', function () {
    return view('pages.bootstrap-nav', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-navbar', function () {
    return view('pages.bootstrap-navbar', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-pagination', function () {
    return view('pages.bootstrap-pagination', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-popover', function () {
    return view('pages.bootstrap-popover', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-progress', function () {
    return view('pages.bootstrap-progress', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-table', function () {
    return view('pages.bootstrap-table', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-tooltip', function () {
    return view('pages.bootstrap-tooltip', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-typography', function () {
    return view('pages.bootstrap-typography', ['type_menu' => 'bootstrap']);
});


// components
Route::get('/components-article', function () {
    return view('pages.components-article', ['type_menu' => 'components']);
});
Route::get('/components-avatar', function () {
    return view('pages.components-avatar', ['type_menu' => 'components']);
});
Route::get('/components-chat-box', function () {
    return view('pages.components-chat-box', ['type_menu' => 'components']);
});
Route::get('/components-empty-state', function () {
    return view('pages.components-empty-state', ['type_menu' => 'components']);
});
Route::get('/components-gallery', function () {
    return view('pages.components-gallery', ['type_menu' => 'components']);
});
Route::get('/components-hero', function () {
    return view('pages.components-hero', ['type_menu' => 'components']);
});
Route::get('/components-multiple-upload', function () {
    return view('pages.components-multiple-upload', ['type_menu' => 'components']);
});
Route::get('/components-pricing', function () {
    return view('pages.components-pricing', ['type_menu' => 'components']);
});
Route::get('/components-statistic', function () {
    return view('pages.components-statistic', ['type_menu' => 'components']);
});
Route::get('/components-tab', function () {
    return view('pages.components-tab', ['type_menu' => 'components']);
});
Route::get('/components-table', function () {
    return view('pages.components-table', ['type_menu' => 'components']);
});
Route::get('/components-user', function () {
    return view('pages.components-user', ['type_menu' => 'components']);
});
Route::get('/components-wizard', function () {
    return view('pages.components-wizard', ['type_menu' => 'components']);
});

// forms
Route::get('/forms-advanced-form', function () {
    return view('pages.forms-advanced-form', ['type_menu' => 'forms']);
});
Route::get('/forms-editor', function () {
    return view('pages.forms-editor', ['type_menu' => 'forms']);
});
Route::get('/forms-validation', function () {
    return view('pages.forms-validation', ['type_menu' => 'forms']);
});

// modules
Route::get('/modules-chartjs', function () {
    return view('pages.modules-chartjs', ['type_menu' => 'modules']);
});
Route::get('/modules-datatables', function () {
    return view('pages.modules-datatables', ['type_menu' => 'modules']);
});
Route::get('/modules-ion-icons', function () {
    return view('pages.modules-ion-icons', ['type_menu' => 'modules']);
});
Route::get('/modules-owl-carousel', function () {
    return view('pages.modules-owl-carousel', ['type_menu' => 'modules']);
});
Route::get('/modules-sparkline', function () {
    return view('pages.modules-sparkline', ['type_menu' => 'modules']);
});
Route::get('/modules-sweet-alert', function () {
    return view('pages.modules-sweet-alert', ['type_menu' => 'modules']);
});
Route::get('/modules-toastr', function () {
    return view('pages.modules-toastr', ['type_menu' => 'modules']);
});

// auth
Route::get('/auth-login2', function () {
    return view('pages.auth-login2', ['type_menu' => 'auth']);
});
Route::get('/auth-register', function () {
    return view('pages.auth-register', ['type_menu' => 'auth']);
});
Route::get('/auth-reset-password', function () {
    return view('pages.auth-reset-password', ['type_menu' => 'auth']);
});

// error
Route::get('/error-403', function () {
    return view('pages.error-403', ['type_menu' => 'error']);
});
Route::get('/error-404', function () {
    return view('pages.error-404', ['type_menu' => 'error']);
});
Route::get('/error-500', function () {
    return view('pages.error-500', ['type_menu' => 'error']);
});
Route::get('/error-503', function () {
    return view('pages.error-503', ['type_menu' => 'error']);
});

// features
Route::get('/features-post-create', function () {
    return view('pages.features-post-create', ['type_menu' => 'features']);
});
Route::get('/features-post', function () {
    return view('pages.features-post', ['type_menu' => 'features']);
});
Route::get('/features-profile', function () {
    return view('pages.features-profile', ['type_menu' => 'features']);
});
Route::get('/features-settings', function () {
    return view('pages.features-settings', ['type_menu' => 'features']);
});
Route::get('/features-setting-detail', function () {
    return view('pages.features-setting-detail', ['type_menu' => 'features']);
});

// Redirect root URL to login page
Route::get('/', function () {
    return redirect()->route('auth.login');
});

// Authentication Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('process');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Dashboard routes
Route::get('/dashboard', function () {
    return view('pages.dashboard-admin', ['type_menu' => 'dashboard']);
})->name('dashboard')->middleware('auth');

// Admin dashboard route
Route::get('/dashboard-admin', function () {
    return view('pages.dashboard-admin', ['type_menu' => 'dashboard']);
})->name('admin.dashboard');

// Admin Manage Users route
Route::get('/manage-users', function () {
    return view('users-admin.manage-user.index', ['type_menu' => 'manage-users']);
})->name('manage-users');

// Manage Users - Staff
Route::group(['prefix' => 'manage-users/staff'], function () {
    Route::get('/', function () {
        return view('users-admin.manage-user.staff.index', ['type_menu' => 'staff']);
    })->name('staff.index');
    Route::post('/list', [StaffController::class, 'list']);
    Route::get('/{id}/show_ajax', [StaffController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [StaffController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [StaffController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [StaffController::class, 'confirm_ajax']);
    Route::post('/{id}/delete_ajax', [StaffController::class, 'delete_ajax']);
});

// Manage Users - Student
Route::group(['prefix' => 'manage-users/student'], function () {
    Route::get('/', function () {
        return view('users-admin.manage-user.student.index', [
            'type_menu' => 'student',
            'students' => StudentModel::all()
        ]);
    })->name('student.index');
    Route::post('/list', [StudentController::class, 'list']);
    Route::get('/{id}/show_ajax', [StudentController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [StudentController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [StudentController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [StudentController::class, 'confirm_ajax']);
    Route::post('/{id}/delete_ajax', [StudentController::class, 'delete_ajax']);
});

// Manage Users - Alumni
Route::group(['prefix' => 'manage-users/alumni'], function () {
    Route::get('/', function () {
        return view('users-admin.manage-user.alumni.index', ['type_menu' => 'alumni']);
    })->name('alumni.index');
    Route::post('/list', [AlumniController::class, 'list']);
    Route::get('/{id}/show_ajax', [AlumniController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [AlumniController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [AlumniController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [AlumniController::class, 'confirm_ajax']);
    Route::post('/{id}/delete_ajax', [AlumniController::class, 'delete_ajax']);
});

// Manage Users - Lecturer
Route::group(['prefix' => 'manage-users/lecturer'], function () {
    Route::get('/', function () {
        return view('users-admin.manage-user.lecturer.index', ['type_menu' => 'lecturer']);
    })->name('lecturer.index');
    Route::post('/list', [LecturerController::class, 'list']);
    Route::get('/{id}/show_ajax', [LecturerController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [LecturerController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LecturerController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LecturerController::class, 'confirm_ajax']);
    Route::post('/{id}/delete_ajax', [LecturerController::class, 'delete_ajax']);
});

// Registration - Admin
Route::get('/registration', function () {
    return view('users-admin.registration.index', [
        'type_menu' => 'registration',
        'user' => UserModel::all()
    ]);
})->name('registration');
Route::post('/registration', [AuthController::class, 'register']);

// student routes
Route::get('/student/profile', [StudentController::class, 'profile'])->name('profile');
Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

// Staff routes
Route::get('/staff/profile', [StaffController::class, 'profile'])->name('staff.profile');
Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');

// Alumni routes
Route::get('/alumni/profile', [AlumniController::class, 'profile'])->name('alumni.profile');
Route::get('/alumni/dashboard', [AlumniController::class, 'dashboard'])->name('alumni.dashboard');

// Lecturer routes
Route::get('/lecturer/profile', [LecturerController::class, 'profile'])->name('lecturer.profile');
Route::get('/lecturer/dashboard', [LecturerController::class, 'dashboard'])->name('lecturer.dashboard');

// admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profile', [AdminProfileController::class, 'show'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});

Route::get('/lecturer/profile', [LecturerController::class, 'show'])->name('lecturer.profile');
Route::post('/lecturer/profile', [LecturerController::class, 'update'])->name('lecturer.profile.update');
