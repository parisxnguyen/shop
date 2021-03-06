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

Route::get('/', 'PageController@getIndex');

Route::get('welcome', function (){
    return view('welcome');
});

Route::get('index',[
	'as'=>'trang-chu',
	'uses'=>'PageController@getIndex'
]);

Route::get('defaultpage',[
	'as'=>'defaultpage',
	'uses'=>'PageController@getIndex'
]);

Route::get('all',[
	'as'=>'all',
	'uses'=>'PageController@getAll'
]);

Route::get('search',[
	'as'=>'search',
	'uses'=>'PageController@getSearch'
]);

Route::get('loai-san-pham/{type}',[
	'as'=>'loaisanpham',
	'uses'=>'PageController@getLoaiSp'
]);

Route::get('chi-tiet-san-pham/{id}',[
	'as'=>'chitietsanpham',
	'uses'=>'PageController@getChitiet'
]);

Route::get('lien-he',[
	'as'=>'lienhe',
	'uses'=>'PageController@getLienHe'
]);

Route::get('gioi-thieu',[
	'as'=>'gioithieu',
	'uses'=>'PageController@getGioiThieu'
]);

Route::get('add-to-cart/{id}',[
	'as'=>'themgiohang',
	'uses'=>'PageController@getAddtoCart'
]);

Route::get('del-cart/{id}',[
	'as'=>'xoagiohang',
	'uses'=>'PageController@getDelItemCart'
]);
Route::get('dat-hang',[
	'as'=>'dathang',
	'uses'=>'PageController@getCheckout'
]);

Route::post('dat-hang',[
	'as'=>'dathang',
	'uses'=>'PageController@postCheckout'
]);

Route::get('dang-nhap',[
	'as'=>'login',
	'uses'=>'PageController@getLogin'
]);
Route::post('dang-nhap',[
	'as'=>'login',
	'uses'=>'PageController@postLogin'
]);

Route::get('dang-ki',[
	'as'=>'signin',
	'uses'=>'PageController@getSignin'
]);

Route::post('dang-ki',[
	'as'=>'signin',
	'uses'=>'PageController@postSignin'
]);

Route::get('dang-xuat',[
	'as'=>'logout',
	'uses'=>'PageController@postLogout'
]);

Route::group(['middleware' => ['admin']], function(){

Route::get('admin', function (){
    return view('admin.admin');
});

Route::get('add-product', 'PageController@Add');

Route::post('add-product', 'PageController@addProduct')->name('add-product');

Route::get('list-product', function (){
    return view('admin.list-product');
});

Route::get('list-product','PageController@listProduct');

Route::get('edit-product/{id}','PageController@editProduct');

Route::post('edit-product/{id}','PageController@editProduct');

Route::get('delete-product/{id}','PageController@removeProduct');

Route::get('list-bill','PageController@listBill');

Route::get('edit-bill/{id}','PageController@editBill');

Route::post('edit-bill/{id}','PageController@editBill');

Route::get('delete-bill/{id}','PageController@removeBill');

Route::get('add-type', function (){
    return view('admin.add-type');
});

Route::post('add-type','PageController@addType');

});