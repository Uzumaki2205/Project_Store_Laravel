<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', function () {
    return redirect('/product/shop');
});
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function () {
    return redirect('/product/shop');
})->name('home');

Route::get('/logout', 'UserController@Logout')->name('logout_user');
// Route::get('/test', 'UserController@test');
Route::group(['prefix' => 'product'], function () {
    Route::get('/', 'ProductController@home');
    Route::get('shop', 'ProductController@AllProduct')->name('Shop');
    Route::get('{slug}', 'ProductController@Details')->name('SearchDetail');
    Route::get('/search/{id_category}', 'ProductController@SearchCategory')->name('search_category');
    Route::get('get-promotion', 'ProductController@GetPromotion')->name('product.get_promotion'); //missing /product
});

// Route::group(['prefix' => 'search'], function () {
//     Route::get('{slug}', function () {
//         return view('welcome');
//     });
// });

Route::group(['prefix' => 'user'], function () {
    Route::get('/info-user', 'UserController@Info')->middleware('auth')->name('InfoUser');
    Route::post('/info-user', 'UserController@UpdateInfo')->middleware('auth')->name('UpdateInfo');
    Route::get('/info-order', 'UserController@InfoOrder')->middleware('auth')->name('InfOrder');
    Route::post('/cancel-order', 'UserController@CancelOrder')->middleware('auth')->name('CancelOrder');

    Route::get('/cart', 'CartController@GetCart')->middleware('auth')->name('Cart');
    // Route::get('/cart', 'CartController@GetCart');
    Route::post('/cart', 'CartController@AddToCart')->middleware('auth')->name('AddToCart');
    Route::post('/update-cart', 'CartController@UpdateCart')->middleware('auth')->name('UpdateCart');
    Route::post('/remove-cart', 'CartController@RemoveCart')->middleware('auth')->name('RemoveCart');
    Route::get('/checkout', 'UserController@ViewCheckout')->middleware('auth')->name('ViewCheckout');
    Route::post('/checkout', 'UserController@Checkout')->middleware('auth')->name('Checkout');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Auth\AdminLoginController@showLogin');
    Route::post('login', 'Auth\AdminLoginController@login');
    Route::get('index', 'AdminController@dashboard');

    Route::get('category-image', 'AdminController@Category_Image');

    Route::get('galery', 'AdminController@Galery');
    Route::post('galery/uploadImage', 'AdminController@UploadImage')->name('admin.UploadImage');

    Route::get('users', 'AdminController@getAllUser');
    Route::post('add-user', 'AdminController@addUser')->name('admin.add-user');
    Route::get('edit-user', 'AdminController@editUser')->name('admin.edit-user');
    Route::post('save-edit-user', 'AdminController@saveEditUser')->name('admin.save-edit-user');
    Route::post('delete-user', 'AdminController@delUser')->name('admin.delete-user');

    Route::get('products/create', 'AdminController@showCreateProduct')->name('admin.showCreateForm');
    Route::post('products/create', 'AdminController@CreateProduct')->name('admin.CreateProduct');
    Route::get('products', 'AdminController@AllProduct');
    Route::get('products/{slug_product}', 'AdminController@Details')->name('admin.slugProduct');
    Route::post('products/update', 'AdminController@UpdateProduct')->name('admin.UpdateProduct');
    Route::post('products/delete', 'AdminController@DeleteProduct')->name('admin.DeleteProduct');

    Route::get('promotions', 'PromotionController@showPromotion');
    Route::post('add-promotion', 'PromotionController@addPromotion')->name('admin.add-promotion');
    Route::get('edit-promotion', 'PromotionController@editPromotion')->name('admin.edit-promotion');
    Route::post('save-edit-promotion', 'PromotionController@saveEditPromotion')->name('admin.save-edit-promotion');
    Route::post('delete-promotion', 'PromotionController@delPromotion')->name('admin.delete-promotion');

    Route::get('categories', 'AdminController@Category');
    Route::post('Add-Category', 'AdminController@CreateCategory')->name('admin.create_category');
    Route::get('Edit-Category', 'AdminController@EditCategory')->name('admin.edit_category');
    Route::post('Update-Category', 'AdminController@UpdateCategory')->name('admin.UpdateCategory');
    // Route::post('Delete-Category', 'AdminController@DeleteCategory')->name('admin.DeleteCategory');

    Route::get('orders/index', 'AdminController@Orders')->name('admin.Order');
    Route::post('orders/accept', 'AdminController@AcceptOrder')->name('admin.AcceptOrder');
    Route::post('orders/dont-accept', 'AdminController@DontAcceptOrder')->name('admin.NotAcceptOrder');

    Route::get('orders/order-cancel', 'AdminController@OrderCancel')->name('admin.OrderCancel');
});
