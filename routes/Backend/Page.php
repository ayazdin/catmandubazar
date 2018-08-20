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
    });
});