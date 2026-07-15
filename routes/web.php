<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/test', function () {
    return "Test";
});

Route::get('/reset-password/{token}', [AuthController::class, 'resetForm'])
    ->name('reset-password');
Route::post('/reset-password/{token}', [AuthController::class, 'postResetPassword'])
    ->name('reset-password.post');

//demo
Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{param1}/{param2}', [DemoController::class, 'index6']);
//
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.home');
Route::get('/test1', [ProductController::class, 'test1']);
Route::get('/test2', [ProductController::class, 'test2']);
//CRUD
Route::prefix('admin')->name('admin.')->group(function () {


    Route::delete('products/delete-image/{imageId}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    // Authentication
    // Login
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])
        ->name('login.post');
    // Forgot password
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])
        ->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postforgotPassword'])
        ->name('forgotpass.post');

    ///
    // CRUD - Resource route
    Route::middleware('roles:1')->group(
        function () {


            Route::resource('brands', BrandController::class);
            Route::resource('users', UserController::class);
            Route::resource('products', ProductController::class);
            Route::resource('posts', PostController::class);
            // ==========================
            // SOFT DELETE CATEGORY
            // ==========================
            // Category trash routes
            Route::get('trash/categories', [CategoryController::class, 'trash'])
                ->name('categories.trash');

            Route::patch('categories/restore-all', [CategoryController::class, 'restoreAll'])
                ->name('categories.restoreAll');

            Route::delete('categories/force-delete-all', [CategoryController::class, 'forceDeleteAll'])
                ->name('categories.forceDeleteAll');

            Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])
                ->name('categories.restore');

            Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])
                ->name('categories.forceDelete');

            Route::resource('categories', CategoryController::class);
            // Brand trash routes
            Route::get('trash/brands', [BrandController::class, 'trash'])->name('brands.trash');
            Route::patch('brands/restore-all', [BrandController::class, 'restoreAll'])->name('brands.restoreAll');
            Route::delete('brands/force-delete-all', [BrandController::class, 'forceDeleteAll'])->name('brands.forceDeleteAll');
            Route::patch('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
            Route::delete('brands/{id}/forcedelete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');

            // Post trash routes
            Route::get('trash/posts', [PostController::class, 'trash'])->name('posts.trash');
            Route::patch('posts/restore-all', [PostController::class, 'restoreAll'])->name('posts.restoreAll');
            Route::delete('posts/force-delete-all', [PostController::class, 'forceDeleteAll'])->name('posts.forceDeleteAll');
            Route::patch('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
            Route::delete('posts/{id}/forcedelete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');

            // Product trash routes
            Route::get('trash/products', [ProductController::class, 'trash'])->name('products.trash');
            Route::patch('products/restore-all', [ProductController::class, 'restoreAll'])->name('products.restoreAll');
            Route::delete('products/force-delete-all', [ProductController::class, 'forceDeleteAll'])->name('products.forceDeleteAll');
            Route::patch('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
            Route::delete('products/{id}/forcedelete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
        }
    );
    // User
    Route::resource('products',ProductController::class)
        ->only(['index'])
        ->middleware('roles:2');

    // Các chức năng yêu cầu đăng nhập}}
    Route::middleware('auth')->group(function () {
        // Restore categories

        // Logout
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        //
        // Đổi mật khẩu
        Route::get('/change-password', [AuthController::class, 'changePassword'])
            ->name('change-password');
        Route::post('/change-password', [AuthController::class, 'postChangePassword'])
            ->name('change-password.post');
    });
});
