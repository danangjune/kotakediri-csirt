<?php

use App\Models\Post;
use App\Models\Footer;
use App\Models\Profil;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\ImagePropertyController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserManagementController;
use App\Models\File;
use App\Models\Guidance;
use App\Models\ImageProperty;
use App\Models\Key;
use App\Models\Service;

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

Route::get('/', function () {

    return view('home', [
        "includeHero" => true,
        'footers' => Footer::latest()->get(),
        'profils' => Profil::latest()->get(),
        'categories' => Category::all(),
        'posts' => Post::where('published', true)->latest()->get(),
        'files' => File::latest()->get(),
        'keys' => Key::latest()->get(),
        'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
        'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
        'guidances' => Guidance::paginate(10)
    ]);
})->name('home')->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('/profil', function () {
    return view('profil', [
        "includeHero" => false,
        'footers' => Footer::latest()->get(),
        'categories' => Category::all(),
        'profils' => Profil::latest()->get(),
        'posts' => Post::where('published', true)->latest()->get(),
        'files' => File::latest()->get(),
        'keys' => Key::latest()->get(),
        'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
        'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
    ]);
})->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('/file', function(){
    return view('file', [
        "includeHero" => false,
        'footers' => Footer::latest()->get(),
        'categories' => Category::all(),
        'profils' => Profil::latest()->get(),
        'posts' => Post::where('published', true)->latest()->get(),
        'files' => File::latest()->get(),
        'keys' => Key::latest()->get(),
        'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
        'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
    ]);
})->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('/service', function(){
    return view('service', [
        "includeHero" => false,
        'footers' => Footer::latest()->get(),
        'categories' => Category::all(),
        'profils' => Profil::latest()->get(),
        'posts' => Post::where('published', true)->latest()->get(),
        'files' => File::latest()->get(),
        'keys' => Key::latest()->get(),
        'services' => Service::latest()->get(),
        'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
        'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
    ]);
})->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('/guidance', function(){
    return view('guidance', [
        "includeHero" => false,
        'footers' => Footer::latest()->get(),
        'categories' => Category::all(),
        'profils' => Profil::latest()->get(),
        'posts' => Post::where('published', true)->latest()->get(),
        'files' => File::latest()->get(),
        'keys' => Key::latest()->get(),
        'services' => Service::latest()->get(),
        'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
        'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
        'guidances' => Guidance::paginate(7)
    ]);
})->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('/contact', function(){
    return view('contact', [
        "includeHero" => false,
        'footers' => Footer::latest()->get(),
        'categories' => Category::all(),
        'profils' => Profil::latest()->get(),
        'posts' => Post::where('published', true)->latest()->get(),
        'files' => File::latest()->get(),
        'keys' => Key::latest()->get(),
        'services' => Service::latest()->get(),
        'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
        'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
    ]);
})->middleware(Spatie\Csp\AddCspHeaders::class);


Route::get('/login-kdrkot', [LoginController::class, 'index'])->name('login')->middleware('white.list','guest',Spatie\Csp\AddCspHeaders::class);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/login/reload-captcha', [LoginController::class, 'reloadCaptcha']);
Route::post('/logout', [LoginController::class, 'logout']);


Route::get('/register', [RegisterController::class, 'index'])->middleware('admin');
Route::get('/register/showChangePasswordGet', [RegisterController::class, 'showChangePasswordGet'])->middleware(Spatie\Csp\AddCspHeaders::class,'auth');
Route::post('/register/showChangePasswordGet', [RegisterController::class, 'changePasswordUser'])->middleware('auth');
Route::post('/register', [RegisterController::class, 'store'])->middleware('admin');


Route::resource('/posts', PostController::class)->only(['index', 'show'])->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('/dashboard', function(){
    return view ('dashboard.index',[
        'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
        'profils' => Profil::latest()->get(),   
    ]);
})->middleware('auth');


Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

Route::get('/dashboard/categories/checkSlug', [AdminCategoryController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin');

Route::resource('/dashboard/footers', FooterController::class)->except('show')->middleware('admin');

Route::resource('/dashboard/properties', ImagePropertyController::class)->except('show')->middleware('admin');
// 

Route::resource('/dashboard/profils', ProfilController::class)->middleware('admin');

Route::resource('/dashboard/files', FileController::class)->only(['index', 'create', 'store', 'destroy'])->middleware('admin');

Route::resource('/dashboard/users', UserManagementController::class)->only(['index', 'edit', 'update'])->middleware(Spatie\Csp\AddCspHeaders::class,'superadmin');

Route::resource('/dashboard/services', ServiceController::class)->middleware('admin');

Route::resource('/dashboard/keys', KeyController::class)->only(['index', 'create', 'store', 'destroy'])->middleware('admin');

Route::resource('/dashboard/guidances', GuidanceController::class)->except('show')->middleware('admin');