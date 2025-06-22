<?php

use App\Http\Controllers\AboutusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetPwController;
use App\Http\Controllers\ForgetPwController2;
use App\Http\Controllers\ForgetPwController3;
use App\Http\Controllers\landingpageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginController2;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegisterController2;
use App\Http\Controllers\RegisterController3;
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
Route::get('/admin', [AdminDashboardController::class, 'index']);
Route::resource('admin_banner', AdminBannerController::class);
Route::resource('admin_product', AdminProductController::class);
Route::resource('admin_blog', AdminBlogController::class);
Route::resource('admin_gallery', AdminGalleryController::class);
Route::resource('admin_category', AdminCategoryController::class);
Route::resource('admin_account', AdminAccountController::class);
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/logindummy', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/logindummy', [AuthController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/logindummydb', function () {
    return view('pages.admin_dashboard');
})->middleware('auth');

Route::get('/hash-password', function () {
    return Hash::make('@dmin');
});

//Form Register
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store'); // <- ini penting

Route::get('/register2', [RegisterController2::class, 'register2']);
Route::post('/register2', [RegisterController2::class, 'store2'])->name('register2.store');

Route::get('/register3', [RegisterController3::class, 'register3']);

//Form Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('auth.login');

//Form Lupa Password
Route::get('/lupa_password', [ForgetPwController::class, 'step1'])->name('lupa_password');
Route::get('/lupa_password2', [ForgetPwController2::class, 'step2']);
Route::get('/lupa_password3', [ForgetPwController3::class, 'step3']);


Route::get('/aboutus', [AboutusController::class, 'aboutus'])->name('aboutus');
Route::get('/settings', [AccountSettingsController::class, 'settingacc'])->name('settings');
Route::get('/passwordchg', [ChgPwController::class, 'passwordchg'])->name('passwordchg');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::post('/blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blog.comment');
Route::get('/list_blog', [ListBlogController::class, 'list_blog'])->name('list_blog');
Route::get('/products', [ProductController::class, 'list'])->name('products');
Route::get('/products/{id}', [ProductController::class, 'product']);
Route::post('/products/{id}/comment', [ProductController::class, 'submitComment']);
Route::get('/list_product', [ListProductController::class, 'index'])->name('list_product');


//Landing Page New Admin Routes 
Route::resource('statistics', CompanyStatisticController::class);
Route::resource('abouts', CompanyAboutController::class);
Route::resource('showcases', ShowcaseController::class);
Route::resource('principles', OurPrincipleController::class);
Route::resource('testimonials', TestimonialController::class);
Route::resource('clients', ProjectClientController::class);
Route::resource('teams', OurTeamController::class);
Route::resource('appointments', AppointmentController::class);
Route::resource('hero_sections', HeroSectionController::class);
