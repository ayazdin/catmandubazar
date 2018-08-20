<?php

Route::group([
    'prefix'    =>  'page',
    'as'        =>  'page.',
    //'namespace' =>  'Page',

],function(){
    Route::group(['namespace' => 'Posts'],function(){
        Route::get('/list', 'PageController@indexPage')->name('indexPage');
        Route::get('/add', 'PageController@createPage')->name('createPage');
        Route::get('edit/{id}', 'PageController@createPage')->name('createPage');
        Route::post('/store', 'PageController@store')->name('store');
        Route::delete('/delete/{id}', 'PageController@destroyPage')->name('destroyPage');
    });
});

Route::group([
    'prefix'    =>  'product',
    'as'        =>  'product.',
],function(){
    Route::group(['namespace'=>'Posts'],function(){
       //product Category
       Route::get('/category/add','PostController@createProductCategory')->name('createProductCategory');
       Route::get('/category/add/{id}','PostController@createProductCategory')->name('createProductCategory');
       Route::post('/store-category','PostController@storeCategory')->name('storeCategory');
       Route::get('/category/delete/{id}','PostController@destroyCategory')->name('destroyCategory');

        //Product entry
       Route::get('/list','PostController@indexProduct')->name('indexProduct');
       Route::get('/add','PostController@createProduct')->name('createProduct');
       Route::post('/store','PostController@store')->name('store');
       Route::get('/edit/{id}','PostController@editProduct')->name('editProduct');
       Route::delete('/delete/{id}','PostController@destroyProduct')->name('destroyProduct');


        //enquiry section
        Route::get('/enquiry','PostController@enquiryList')->name('enquiryList');
        Route::delete('/enquiry/delete/{id}','PostController@destroyEnquiry')->name('destroyEnquiry');
    });
});

Route::group([
    'prefix'    =>  'post',
    'as'        =>  'post.',
],function(){
    Route::group(['namespace'=>'Posts'],function(){
        //Post Category
        Route::get('/category/add','PostController@createPostCategory')->name('createPostCategory');
        Route::get('/category/add/{id}','PostController@createPostCategory')->name('createPostCategory');
        Route::post('/store-category','PostController@storePostCategory')->name('storePostCategory');
        Route::get('/category/delete/{id}','PostController@destroyPostCategory')->name('destroyPostCategory');

        //Post entry
        Route::get('/list','PostController@indexPost')->name('indexPost');
        Route::get('/add','PostController@createPost')->name('createPost');
        Route::post('/store','PostController@storePost')->name('storePost');
        Route::get('/edit/{id}','PostController@editPost')->name('editPost');
        Route::delete('/delete/{id}','PostController@destroyPost')->name('destroyPost');

    });
});