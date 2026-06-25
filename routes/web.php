<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\FeatureController;
use App\Models\LandingPage;
use App\Models\Feature;
use App\Models\User;

use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $landing = LandingPage::first();
    $features = Feature::orderBy('sort_order')->get();

    return view('landing', compact('landing', 'features'));
})->name('home');

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

Route::get('/syarat-ketentuan', function () {
    $landing = LandingPage::first();
    return view('terms', compact('landing'));
})->name('terms');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        $totalFeatures = Feature::count();
        $totalUsers = User::count();
        $recentFeatures = Feature::latest()->take(5)->get();
        $totalAppointments = \App\Models\Appointment::count();
        return view('admin.dashboard', compact('totalFeatures', 'totalUsers', 'recentFeatures', 'totalAppointments'));
    })->name('admin.dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Landing Page CMS
    Route::get('/admin/landing-page', [LandingPageController::class, 'index'])->name('admin.landing.edit');
    Route::put('/admin/landing-page', [LandingPageController::class, 'update'])->name('admin.landing.update');

    // Features CMS
    Route::get('/admin/features', [FeatureController::class, 'index'])->name('admin.features.index');
    Route::get('/admin/features/create', [FeatureController::class, 'create'])->name('admin.features.create');
    Route::post('/admin/features', [FeatureController::class, 'store'])->name('admin.features.store');
    Route::get('/admin/features/{id}/edit', [FeatureController::class, 'edit'])->name('admin.features.edit');
    Route::put('/admin/features/{id}', [FeatureController::class, 'update'])->name('admin.features.update');
    Route::delete('/admin/features/{id}', [FeatureController::class, 'destroy'])->name('admin.features.destroy');

    // Appointments Management
    Route::get('/admin/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::patch('/admin/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('admin.appointments.updateStatus');
    Route::delete('/admin/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');

    // Users Management
    Route::get('/admin/users', function () {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    })->name('admin.users.index');
});

require __DIR__ . '/auth.php';
