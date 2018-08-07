<?php

/*
|--------------------------------------------------------------------------
| Products Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin/product/'], function () {
  Route::get('list', ['as' => 'list', 'uses' => 'Posts\PostsController@indexProduct'])->middleware('admin');
  Route::get('add', ['as' => 'add', 'uses' => 'Posts\PostsController@createProduct'])->middleware('admin');
  Route::get('edit/{id}', ['as' => 'edit/{id}', 'uses' => 'Posts\PostsController@editProduct'])->middleware('admin');
  Route::get('category/add', ['as' => 'category/add', 'uses' => 'Posts\PostsController@createProductCategory'])->middleware('admin');
  Route::get('type/add', ['as' => 'type/add', 'uses' => 'Posts\PostsController@createProductType'])->middleware('admin');
  Route::get('category/add/{id}', ['as' => 'category/add/{id}', 'uses' => 'Posts\PostsController@createProductCategory'])->middleware('admin');
  Route::get('type/add/{id}', ['as' => 'type/add/{id}', 'uses' => 'Posts\PostsController@createProductType'])->middleware('admin');
  Route::get('type/relation/{id}', ['as' => 'type/relation/{id}', 'uses' => 'Posts\PostsController@getSubsOfProductType'])->middleware('admin');
  Route::get('category/delete/{id}', ['as' => 'category/delete/{id}', 'uses' => 'Posts\PostsController@destroyCategory'])->middleware('admin');
  Route::get('order-list/', ['as' => 'order-list/', 'uses' => 'Posts\PostsController@getProductOrderList'])->middleware('admin');
  Route::get('view-order/{orderid}', ['as' => 'view-order/{orderid}', 'uses' => 'Posts\PostsController@getProductOrderView'])->middleware('admin');
});
