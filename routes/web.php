<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

// Authentication Routes...
Route::get('/admin/login', [
  'as' => 'admin/login',
  'uses' => 'Auth\LoginController@showAdminLoginForm'
]);
/*Route::post('login', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@login'
]);*/
/*Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);*/

// Password Reset Routes...
/*Route::post('password/email', [
  'as' => 'password.email',
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
  'as' => 'password.request',
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
  'as' => '',
  'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
  'as' => 'password.reset',
  'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

// Registration Routes...
Route::get('register', [
  'as' => 'register',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('register', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);*/

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/home', 'HomeController@index')->name('dashboard');

Route::group(['prefix' => '/admin/page/'], function () {
  Route::get('list', ['uses' => 'Posts\PageController@indexPage'])->middleware('admin');
  Route::get('add', ['uses' => 'Posts\PageController@createPage'])->middleware('admin');
  Route::get('edit/{id}', ['uses' => 'Posts\PageController@createPage'])->middleware('admin');
  Route::post('store', ['uses' => 'Posts\PageController@store'])->middleware('admin');
  Route::get('delete/{id}',['uses'=>'Posts\PageController@destroyPage'])->middleware('admin');
});

Route::group(['prefix' => 'admin/product/'], function () {

  //product
  Route::get('list', ['as' => 'list', 'uses' => 'Posts\PostsController@indexProduct'])->middleware('admin');
  Route::get('add', ['as' => 'add', 'uses' => 'Posts\PostsController@createProduct'])->middleware('admin');
  Route::post('store', ['as' => 'store', 'uses' => 'Posts\PostsController@store'])->middleware('admin');
  Route::get('edit/{id}', ['as' => 'edit/{id}', 'uses' => 'Posts\PostsController@editProduct'])->middleware('admin');
  Route::get('delete/{id}',['uses'=>'Posts\PostsController@destroyPost'])->middleware('admin');


  //product category
  Route::get('category/add', ['as' => 'category/add', 'uses' => 'Posts\PostsController@createProductCategory'])->middleware('admin');
  Route::get('category/add/{id}', ['as' => 'category/add/{id}', 'uses' => 'Posts\PostsController@createProductCategory'])->middleware('admin');
  Route::post('store-category',['as' => 'store-category', 'uses' => 'Posts\PostsController@storeCategory'])->middleware('admin');
  Route::get('category/delete/{id}', ['as' => 'category/delete/{id}', 'uses' => 'Posts\PostsController@destroyCategory'])->middleware('admin');

  //Branding
  Route::get('brand',['as'=>'brand','uses'=>'Posts\PostsController@brandIndex'])->middleware('admin');
  Route::get('brand/{id}',['as'=>'brand/{id}','uses'=>'Posts\PostsController@brandIndex'])->middleware('admin');
  Route::get('brand/delete/{id}',['as'=>'brand/delete/{id}','uses'=>'Posts\PostsController@branddestroy'])->middleware('admin');
  Route::post('brand-store',['as'=>'brand-store','uses'=>'Posts\PostsController@brandstore'])->middleware('admin');



  Route::get('type/add', ['as' => 'type/add', 'uses' => 'Posts\PostsController@createProductType'])->middleware('admin');
  Route::get('type/add/{id}', ['as' => 'type/add/{id}', 'uses' => 'Admin\Posts\PostsController@createProductType'])->middleware('admin');
  Route::get('type/relation/{id}', ['as' => 'type/relation/{id}', 'uses' => 'Admin\Posts\PostsController@getSubsOfProductType'])->middleware('admin');
  Route::get('order-list/', ['as' => 'order-list/', 'uses' => 'Admin\Posts\PostsController@getProductOrderList'])->middleware('admin');
  Route::get('view-order/{orderid}', ['as' => 'view-order/{orderid}', 'uses' => 'Admin\Posts\PostsController@getProductOrderView'])->middleware('admin');
});



/*
 * Routes for Frontend
 */
Route::group(
    [
      'prefix'  =>'/',
      'as' => 'frontend.'
    ],
    function(){
      Route::get('','Frontend\FrontendController@getHomePage')->name('getHomePage');
      Route::get('product/{slug}','Frontend\FrontendController@produtDetail')->name('produtDetail');
      Route::post('product-enquiry','Frontend\FrontendController@productEnquiry')->name('productEnquiry');
    });