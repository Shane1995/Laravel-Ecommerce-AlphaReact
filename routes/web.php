<?php

Route::get('/', ["uses" => "ProductsContoller@index", "as" => "AllProducts"]);
Route::get('products', ["uses" => "ProductsContoller@index", "as" => "AllProducts"]);
Route::get('product/addToCart/{id}', ['uses' => "ProductsContoller@addProductToCart", 'as' => 'AddToCartProduct']);
//oder history
Route::get('orderHistory', 'payment\PaymentsController@getUserOrder')->name('orderHistory');
//Get selected Products 
Route::get('orderedItem/{id}', 'payment\PaymentsController@orderItems')->name('orderItems');
//view cart 
Route::get('cart', ["uses" => "ProductsContoller@showCart", "as" => "cartProducts"]);
//delete item from cart 
Route::get('product/deleteItemFromCart/{id}', ['uses' => "ProductsContoller@deleteItemFormToCart", 'as' => 'deleteItemFromCart']);
//get the selected category
Route::get('products/{cat}', ["uses" => "ProductsContoller@getCategoryProducts", "as" => "getCategoryProducts"]);
Route::get('products/getbrand/{brand}', ["uses" => "ProductsContoller@getBrandsProducts", "as" => "getBrandsProducts"]);
//view individual products 
Route::get('products/getProduct/{id}', ["uses" => "ProductsContoller@getProduct", "as" => "getProduct"]);
//search 
Route::get('search', ["uses" => "ProductsContoller@searchForProduct", "as" => "searchForProduct"]);
//user authentication 
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
/*
    quantity manipulation
*/
//increase 
Route::get('product.increase.{id}', ["uses" => "ProductsContoller@increaseSingleProduct", "as" => "increaseSingleProduct"]);
//decrease 
Route::get('product.decrease.{id}', ["uses" => "ProductsContoller@decreaseSingleProduct", "as" => "decreaseSingleProduct"]);
/*
   end quantity manipulation
*/
//Checkout page
Route::get('product/checkoutProducts', ['uses' => 'ProductsContoller@checkoutProducts', 'as' => 'checkoutProducts']);
//process checkout page 
Route::post('product.createNewOrder', ["uses" => "ProductsContoller@createNewOrder", "as" => "createNewOrder"]);
//create order route
Route::get('product.createOrder', ["uses" => "ProductsContoller@createOrder", "as" => "createOrder"]);
//update users details
Route::post('updateUserDetails.update', ["uses" => "UserController@updateUserDetails", 'as' => 'updateUserDetails']);
//payment page
Route::get('payment.paymentpage', ["uses" => "payment\PaymentsController@showPaymentPage", "as" => "showPaymentPage"]);
Route::get('payment.paymentreceipt/{paymentID}/{payerID}', ["uses" => "payment\PaymentsController@showPaymentReceipt", 'as' => 'showPaymentReceipt']);

//About us 
Route::get('AboutUs', ["uses" => "HomeController@AboutUs", "as" => "AboutUs"]);



//Group the admin routes with the middleware 
Route::group(['middleware' => ['restrictToAdmin']], function () {

    //Admin Panel
    Route::get('admin/', ["uses" => "Admin\AdminProductsController@index", "as" => "adminDisplayProducts"]);
    Route::get('admin/products', ["uses" => "Admin\AdminProductsController@index", "as" => "adminDisplayProducts"]);

    //display edit product form
    Route::get('admin/editProductForm/{id}', ["uses" => "Admin\AdminProductsController@editProductForm", "as" => "adminEditProductForm"]);

    //display edit product image form
    Route::get('admin/editProductImageForm/{id}', ["uses" => "Admin\AdminProductsController@editProductImageForm", "as" => "adminEditProductImageForm"]);

    //delete product
    Route::get('admin/deleteProduct/{id}', ["uses" => "Admin\AdminProductsController@deleteProduct", "as" => "adminDeleteProduct"]);

    //update product image
    Route::post('admin/updateProductImage/{id}', ["uses" => "Admin\AdminProductsController@updateProductImage", "as" => "adminUpdateProductImage"]);

    //update product details
    Route::post('admin/updateProduct/{id}', ["uses" => "Admin\AdminProductsController@updateProduct", "as" => "adminUpdateProduct"]);

    //display insert product form
    Route::get('admin/createProductForm', ["uses" => "Admin\AdminProductsController@createProductForm", "as" => "adminCreateProductForm"]);

    //send new product details to database
    Route::post('admin/sendCreateProductForm', ["uses" => "Admin\AdminProductsController@sendCreateProductForm", "as" => "adminSendCreateProductForm"]);

    //Order panel 
    Route::get('admin/ordersPanel', ["uses" => "Admin\AdminProductsController@ordersPanel", "as" => "ordersPanel"]);

    //delete order
    Route::get('admin/deleteOrder/{id}', ["uses" => "Admin\AdminProductsController@deleteOrder", "as" => "adminDeleteOrder"]);

    //getPaymentInfoByOrderId
    Route::get('payment/getPaymentInfoByOrderId/{order_id}', [
        "uses" => "payment\PaymentsController@getPaymentInfoByOrderId", "as" => "getPaymentInfoByOrderId"
    ]);

    //display edit order form
    Route::get('admin/editOrderForm/{order_id}', ["uses" => "Admin\AdminProductsController@editOrderForm", "as" => "adminEditOrderForm"]);


    //update order data
    Route::post('admin/updateOrder/{order_id}', ["uses" => "Admin\AdminProductsController@updateOrder", "as" => "adminUpdateOrder"]);

    //display users 
    Route::get('admin/displayUser', ["uses" => "Admin\AdminProductsController@displayUser", "as" => "displayUser"]);

    //display user's order 
    Route::get('admin/displayOrder/{id}', ["uses" => "Admin\AdminProductsController@displayUserOrder", "as" => "displayUserOrder"]);
    //displaying selected Items 
    Route::get('admin/displayItems/{id}', ["uses" => "Admin\AdminProductsController@displayItems", "as" => "displayItems"]);

    //Add admin 
    Route::get('admin/addAdmin/{id}', ["uses" => "Admin\AdminProductsController@addAdmin", "as" => "addAdmin"]);
    //remove admin
    Route::get('admin/removeAdmin/{id}', ["uses" => "Admin\AdminProductsController@removeAdmin", "as" => "removeAdmin"]);

    Route::get('admin/removeUser/{id}', ["uses" => "Admin\AdminProductsController@removeUser", "as" => "removeUser"]);

    Route::get('admin/analytics', ["uses" => "Admin\AdminProductsController@analytics", "as" => "analytics"]);

    //ship order 

    Route::get('admin/shipOrder/{id}', ["uses" => "Admin\AdminProductsController@shipOrder", "as" => "shipOrder"]);
});