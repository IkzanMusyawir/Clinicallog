<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\FeatureController;
use App\Models\LandingPage;
use App\Models\Feature;
use App\Models\User;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $landingData = Cache::remember('landing_page_data', 3600, function () {
        $model = LandingPage::first();
        return $model ? $model->getAttributes() : null;
    });

    $landing = null;
    if ($landingData) {
        $landing = new LandingPage();
        $landing->setRawAttributes($landingData);
        $landing->exists = true;
        $landing->syncOriginal();
    }

    $features = Feature::orderBy('sort_order')->get();

    return view('landing', compact('landing', 'features'));
})->name('home');

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

Route::get('/syarat-ketentuan', function () {
    $landingData = Cache::remember('landing_page_data', 3600, function () {
        $model = LandingPage::first();
        return $model ? $model->getAttributes() : null;
    });

    $landing = null;
    if ($landingData) {
        $landing = new LandingPage();
        $landing->setRawAttributes($landingData);
        $landing->exists = true;
        $landing->syncOriginal();
    }

    return view('terms', compact('landing'));
})->name('terms');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        $totalFeatures = Cache::remember('dash_features', 300, function () { return Feature::count(); });
        $totalUsers = Cache::remember('dash_users', 300, function () { return User::count(); });
        $recentAppointments = Cache::remember('dash_recent_appointments', 300, function () { return \App\Models\Appointment::latest()->take(5)->get(['name', 'institution', 'status'])->toArray(); });
        $recentAppointments = collect($recentAppointments)->map(fn($a) => (object) $a);
        $totalAppointments = Cache::remember('dash_appointments_total', 300, function () { return \App\Models\Appointment::count(); });
        return view('admin.dashboard', compact('totalFeatures', 'totalUsers', 'recentAppointments', 'totalAppointments'));
    })->name('admin.dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Landing Page CMS
    Route::get('/admin/landing-page', [LandingPageController::class, 'index'])->name('admin.landing.edit');
    Route::get('/admin/landing-page/panel/{name}', [LandingPageController::class, 'panel'])->name('admin.landing.panel');
    Route::put('/admin/landing-page', [LandingPageController::class, 'update'])->name('admin.landing.update');

    // Features CMS
    Route::post('/admin/features/sort-order', [FeatureController::class, 'updateSortOrder'])->name('admin.features.sort-order');
    Route::get('/admin/features', [FeatureController::class, 'index'])->name('admin.features.index');
    Route::post('/admin/features', [FeatureController::class, 'store'])->name('admin.features.store');
    Route::put('/admin/features/{id}', [FeatureController::class, 'update'])->name('admin.features.update');
    Route::delete('/admin/features/{id}', [FeatureController::class, 'destroy'])->name('admin.features.destroy');

    // Appointments Management
    Route::get('/admin/appointments/realtime-status', [AppointmentController::class, 'getRealtimeStatus'])->name('admin.appointments.realtimeStatus');
    Route::get('/admin/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::patch('/admin/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('admin.appointments.updateStatus');
    Route::delete('/admin/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');

    // Users Management
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

require __DIR__ . '/auth.php';
