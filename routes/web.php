<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Demo\Admin\DemoAdminController;
use App\Http\Controllers\Demo\Cart\DemoCartController;
use App\Http\Controllers\Demo\Multi\DemoMultiImageController;
use App\Http\Controllers\Demo\Package\DemoPackageController;
use App\Http\Controllers\Demo\Post\DemoPostController;
use App\Http\Controllers\Demo\Prodcut\DemoProductController;
use App\Http\Controllers\Demo\Projectv1\DemoAdminUserController;
use App\Http\Controllers\Demo\Relationship\DemoRelationshipController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// Route::get('/', [DemoProductController::class, 'show'])->name('demo.product.show');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// DEMO DEMO DEMO
Route::prefix('demo/package/')->group(function () {

    Route::get('index', [DemoPackageController::class, 'index'])->name('demo.package.index');
    Route::get('list', [DemoPackageController::class, 'list'])->name('demo.package.list');
    Route::get('sendmail', [DemoPackageController::class, 'sendmail'])->name('demo.package.sendmail');
    Route::get('add', [DemoPackageController::class, 'add'])->name('demo.package.add');
    Route::get('store', [DemoPackageController::class, 'store'])->name('demo.package.store');
    Route::post('store', [DemoPackageController::class, 'store'])->name('demo.package.store');
    Route::get('delete/{id}', [DemoPackageController::class, 'delete'])->name('demo.package.delete');
    Route::get('edit/{id}', [DemoPackageController::class, 'edit'])->name('demo.package.edit');
    Route::get('detail/{id}', [DemoPackageController::class, 'detail'])->name('demo.package.detail');

});

Route::prefix('demo/cart/')->group(function () {

    Route::get('show', [DemoCartController::class, 'show'])->name('demo.cart.show');
    Route::get('add/{id}', [DemoCartController::class, 'add'])->name('demo.cart.add');
    Route::get('remove/{rowId}', [DemoCartController::class, 'remove'])->name('demo.cart.remove');
    Route::get('destroy', [DemoCartController::class, 'destroy'])->name('demo.cart.destroy');
    Route::post('update', [DemoCartController::class, 'update'])->name('demo.cart.update');
    Route::get('ajax', [DemoCartController::class, 'ajaxCart'])->name('demo.cart.ajax');
    Route::post('checkout-coupon', [DemoCartController::class, 'checkoutCoupon'])->name('demo.cart.checkout_coupon');
    Route::get('checkout-coupon', [DemoCartController::class, 'checkoutCoupon'])->name('demo.cart.checkout_coupon');
    Route::post('update-cart', [DemoProductController::class, 'updateCart'])->name('demo.update_cart');
    Route::delete('delete-cart', [DemoProductController::class, 'deleteCart'])->name('demo.delete_cart');
});

Route::prefix('demo/product/')->group(function () {

    Route::get('show', [DemoProductController::class, 'show'])->name('demo.product.show');
    Route::get('detail/{id}', [DemoProductController::class, 'detail'])->name('demo.product.detail');
    Route::post('save-product', [DemoProductController::class, 'saveProduct'])->name('demo.product.save');
    Route::post('add-cart-ajax', [DemoProductController::class, 'addCartAjax'])->name('add-cart-ajax');
    Route::delete('delete-product/{session_id}', [DemoProductController::class, 'deleteProduct'])->name('delete_product');

});

// Mulit Image Route
Route::prefix('demo/multi/images')->group(function () {

    Route::get('add', [DemoMultiImageController::class, 'add'])->name('demo.multi.add');
    Route::get('action', [DemoMultiImageController::class, 'action'])->name('demo.multi.action');
    Route::post('action', [DemoMultiImageController::class, 'action'])->name('demo.multi.action');
    Route::get('edit/{id}', [DemoMultiImageController::class, 'edit'])->name('demo.multi.edit');
    Route::get('update/{id}', [DemoMultiImageController::class, 'update'])->name('demo.multi.update');
    Route::post('update/{id}', [DemoMultiImageController::class, 'update'])->name('demo.multi.update');
    Route::get('delete/{id}', [DemoMultiImageController::class, 'delete'])->name('demo.multi.delete');
    Route::get('list', [DemoMultiImageController::class, 'list'])->name('demo.multi.list');
    Route::get('listv2', [DemoMultiImageController::class, 'listv2'])->name('demo.multi.listv2');
    Route::get('store', [DemoMultiImageController::class, 'store'])->name('demo.multi.store');
    Route::post('store', [DemoMultiImageController::class, 'store'])->name('demo.multi.store');
    Route::get('deleteAll', [DemoMultiImageController::class, 'deleteAll'])->name('demo.multi.deleteAll');


});

Route::prefix('demo/relationship/')->group(function () {

    Route::get('index', [DemoRelationshipController::class, 'index'])->name('demo.relationship.index');

});

Route::prefix('demo/post/')->group(function () {

    Route::get('read', [ DemoPostController::class, 'read'])->name('demo.post.read');
    Route::get('add', [ DemoPostController::class, 'add'])->name('demo.post.add');
    Route::get('update/{id}', [ DemoPostController::class, 'update'])->name('demo.post.update');
    Route::get('delete/{id}', [ DemoPostController::class, 'delete'])->name('demo.post.delete');
    Route::get('restore/{id}', [ DemoPostController::class, 'restore'])->name('demo.post.restore');
    Route::get('destroy/{id}', [ DemoPostController::class, 'destroy'])->name('demo.post.destroy');

});

Route::prefix('demo/admin/')->group(function () {

    // Route::get('read/{age}', [  DemoAdminController::class, 'index'])->name('demo.admin.index')->middleware('DemoCheckAge');
    Route::get('read/{age}', [  DemoAdminController::class, 'index'])->name('demo.admin.index');

});

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

// Route::get('admin/dashboard', [  AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('CheckRole');

Route::middleware('auth')->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

    Route::get('admin/dashboard', [  AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('CheckRole');

    Route::prefix('projectv1/admin/user/')->group(function () {

        Route::get('list', [DemoAdminUserController::class, 'list'])->name('projectv1.user.list');
        Route::post('list', [DemoAdminUserController::class, 'list'])->name('projectv1.user.list');
        Route::get('add', [DemoAdminUserController::class, 'add'])->name('projectv1.user.add');
        Route::get('edit/{id}', [DemoAdminUserController::class, 'edit'])->name('projectv1.user.edit');
        Route::get('update/{id}', [DemoAdminUserController::class, 'update'])->name('projectv1.user.update');
        Route::post('update/{id}', [DemoAdminUserController::class, 'update'])->name('projectv1.user.update');
        Route::get('store', [DemoAdminUserController::class, 'store'])->name('projectv1.user.store');
        Route::post('store', [DemoAdminUserController::class, 'store'])->name('projectv1.user.store');
        Route::post('action', [DemoAdminUserController::class, 'action'])->name('projectv1.user.action');
        Route::get('delete/{id}', [DemoAdminUserController::class, 'delete'])->name('projectv1.user.delete');
        Route::get('districts/ajax/{province_id}', [DemoAdminUserController::class, 'GetDistricts']);
        Route::get('wards/ajax/{province_id}', [DemoAdminUserController::class, 'GetWards']);
        Route::post('districts/ajax/{province_id}', [DemoAdminUserController::class, 'GetDistricts']);
        Route::post('wards/ajax/{province_id}', [DemoAdminUserController::class, 'GetWards']);
        //

    });

});



