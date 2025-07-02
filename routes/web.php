<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutusController;
use Illuminate\Support\Facades\Route;

// Middleware
use App\Http\Middleware\AdminMiddleware;

// Admin Routes
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\AuthController;

// Auth Routes
use App\Http\Controllers\ForgetPwController;
use App\Http\Controllers\ForgetPwController2;
use App\Http\Controllers\ForgetPwController3;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegisterController2;
use App\Http\Controllers\RegisterController3;

// Users Routes
use App\Http\Controllers\landingpageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ListProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChgPwController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CompanyAboutController;
use App\Http\Controllers\CompanyStatisticController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\ListBlogController;
use App\Http\Controllers\OurPrincipleController;
use App\Http\Controllers\OurTeamController;
use App\Http\Controllers\ProjectClientController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\TestimonialController;


//Landing Page
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/team', [FrontController::class, 'team'])->name('front.team');
Route::get('/about', [FrontController::class, 'about'])->name('front.about');

//Admin Routes
Route::middleware([
    \Illuminate\Auth\Middleware\Authenticate::class,
    \App\Http\Middleware\AdminMiddleware::class,
])->prefix('admin')->group(function () {
    Route::get('', [AdminDashboardController::class, 'index']);
    Route::resource('banner', AdminBannerController::class);
    Route::resource('product', AdminProductController::class);
    Route::resource('blog', AdminBlogController::class);
    Route::resource('gallery', AdminGalleryController::class);
    Route::resource('category', AdminCategoryController::class);
    Route::resource('account', AdminAccountController::class);
});

Route::middleware([
    \Illuminate\Auth\Middleware\Authenticate::class,
    \App\Http\Middleware\AdminMiddleware::class,
])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('statistics', CompanyStatisticController::class);
    Route::resource('abouts', CompanyAboutController::class);
    Route::resource('showcases', ShowcaseController::class);
    Route::resource('principles', OurPrincipleController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('clients', ProjectClientController::class);
    Route::resource('teams', OurTeamController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('hero_sections', HeroSectionController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/hash-password', function () {
    return Hash::make('@dmin');
});

// Form Register
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store'); // <- ini penting
Route::get('/register2', [RegisterController2::class, 'register2']);
Route::post('/register2', [RegisterController2::class, 'store2'])->name('register2.store');
Route::get('/register3', [RegisterController3::class, 'register3']);
Route::post('/register3', [RegisterController3::class, 'verifyOtp'])->name('register3.verify');

Route::get('/test-send-otp', function () {
    $token = config('services.fonnte.token');
    $phone = '6282170640976'; // GANTI dengan nomor WhatsApp kamu
    $otp = rand(1000, 9999); // Bisa juga 1234 untuk fix testing

    $response = Http::withToken($token)->post('https://api.fonnte.com/send', [
        'target'  => $phone,
        'message' => "Ini pesan tes.\nKode OTP kamu: *$otp*",
    ]);

    if ($response->successful()) {
        return "Sukses kirim OTP ke $phone";
    } else {
        return response()->json([
            'error' => 'Gagal kirim',
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
    }
});

Route::get('/test-otp', function () {
    $token = 'zYmnGtaD58JUxy3nu59w'; // tempel token langsung tanpa spasi

    $response = Http::withToken($token)->post('https://api.fonnte.com/send', [
        'target' => '6282170640976',
        'message' => 'Tes kirim dari Laravel langsung',
    ]);

    return $response->body();
});

// Form Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Form Lupa Password
Route::get('/lupa_password', [ForgetPwController::class, 'step1'])->name('lupa_password');
Route::get('/lupa_password2', [ForgetPwController2::class, 'step2']);
Route::get('/lupa_password3', [ForgetPwController3::class, 'step3']);

// Users Routes
Route::get('/aboutus', [AboutusController::class, 'aboutus'])->name('aboutus');
Route::get('/passwordchg', [ChgPwController::class, 'passwordchg'])->name('passwordchg');
Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery');


Route::get('/blogs', [BlogController::class, 'index'])->name('blog');
Route::get('/blogs/{id}', [BlogController::class, 'blog'])->name('admin.blog.show');
Route::post('/blogs/{id}/comment', [BlogController::class, 'comments'])->middleware('auth');
Route::post('/blogs/{id}/replies', [BlogController::class, 'replies'])->middleware('auth');
Route::get('/list_blog', [ListBlogController::class, 'list_blog'])->name('list_blog');

Route::get('/products', [ProductController::class, 'list'])->name('products');
Route::get('/products/{id}', [ProductController::class, 'product']);
Route::post('/products/{id}/comment', [ProductController::class, 'comments'])->middleware('auth');
Route::post('/products/{id}/replies', [ProductController::class, 'replies'])->middleware('auth');
Route::get('/list_product', [ListProductController::class, 'index'])->name('list_product');

Route::get('/settings', [AccountSettingsController::class, 'index'])->name('settings.index');
Route::get('/settings/password', [AccountSettingsController::class, 'password'])->name('settings.password');
Route::put('/settings/profile', [AccountSettingsController::class, 'updateProfile'])->name('settings.profile.update');
Route::put('/settings/password', [AccountSettingsController::class, 'updatePassword'])->name('settings.password.update');


//Auth
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__.'/auth.php';
