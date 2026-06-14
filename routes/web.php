<?php

use App\Http\Controllers\{AdminController, CartController, HomeController, ShopController, UserController, WishlistController};
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripeController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

Route::post('logout',[HomeController::class,'logout'])->name('logout');
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');

Route::post('/cart/increase-quantity/{rowId}',[CartController::class,'increase_cart_quantity'])->name('increase.cart.quantity');
Route::post('/cart/decrease-quantity/{rowId}',[CartController::class,'decrease_cart_quantity'])->name('decrease.cart.quantity');

Route::delete('cart/remove/{rowId}',[CartController::class,'remove_item'])->name('cart.item.remove');
Route::delete('cart/clear',[CartController::class,'empty_cart'])->name('cart.empty');

//wishlist
Route::post('/wishlist/add',[WishlistController::class,'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist',[WishlistController::class,'index'])->name('wishlist.index');
Route::delete('/wishlist/item/remove/{rowId}',[WishlistController::class,'remove_item'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear',[WishlistController::class,'empty_wishlist'])->name('wishlist.item.clear');
Route::post('/wishlist/move-to-cart/{rowId}',[WishlistController::class,'move_to_cart'])->name('wishlist.move.to.cart');
//Apply coupon
Route::post('/cart/apply-coupon',[CartController::class,'apply_coupon_code'])->name('cart.coupon.apply');
Route::delete('/cart/remove-coupon',[CartController::class,'remove_coupon_code'])->name('cart.coupon.remove');
//checkout
Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout');
//place order
Route::post('/place-an-order',[CartController::class,'place_an_order'])->name('cart.place.an.order');
Route::get('/order-confirmation',[CartController::class,'order_confirmation'])->name('cart.order.confirmation');

//contact
Route::get('contact-us',[HomeController::class,'contact'])->name('home.contact');
Route::post('contact-us/store',[HomeController::class,'contact_store'])->name('home.contact.store');

//home search
Route::get('/search',[HomeController::class,'search'])->name('home.search');

Route::middleware(['auth'])->group(function(){
    Route::get('account-dashboard',[UserController::class,'index'])->name('user.index');

//user orders
Route::get('/account-orders',[UserController::class,'orders'])->name('user.orders');
Route::get('/account-orders/details/{order_id}',[UserController::class,'order_details'])->name('user.orders.details');
Route::put('/account-orders/cancel-order',[UserController::class,'order_cancel'])->name('user.order.cancel');

});

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout'])->name('example1');
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout'])->name('example2');

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


// stripe webhooks

Route::get('/stripe/success', [StripeController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('/stripe/cancel', [StripeController::class, 'stripeCancel'])->name('stripe.cancel');



Route::middleware(['auth',AuthAdmin::class])->group(function(){
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');

    //brands
    Route::get('/admin/brands',[AdminController::class,'brands'])->name('admin.brands');
    Route::get('/admin/brands/add',[AdminController::class,'add_brand'])->name('admin.brands.add');
    Route::post('/admin/brands/store',[AdminController::class,'brand_store'])->name('admin.brands.store');
    Route::get('/admin/brands/edit/{id}',[AdminController::class,'brand_edit'])->name('admin.brands.edit');
    Route::post('/admin/brands/update/{id}',[AdminController::class,'brand_update'])->name('admin.brands.update');
    Route::delete('/admin/brands/delete/{id}',[AdminController::class,'brand_delete'])->name('admin.brands.delete');

    //categories
    Route::get('/admin/categories',[AdminController::class,'categories'])->name('admin.categories');
    Route::get('/admin/categories/add',[AdminController::class,'add_category'])->name('admin.categories.add');
    Route::post('/admin/categories/store',[AdminController::class,'category_store'])->name('admin.categories.store');
    Route::get('/admin/categories/edit/{id}',[AdminController::class,'category_edit'])->name('admin.categories.edit');
    Route::post('/admin/categories/update/{id}',[AdminController::class,'category_update'])->name('admin.categories.update');
    Route::delete('/admin/categories/delete/{id}',[AdminController::class,'category_delete'])->name('admin.categories.delete');

    //products
    Route::get('/admin/products',[AdminController::class,'products'])->name('admin.products');
    Route::get('/admin/products/add',[AdminController::class,'add_product'])->name('admin.products.add');
    Route::post('/admin/products/store',[AdminController::class,'product_store'])->name('admin.products.store');
    Route::get('/admin/products/edit/{id}',[AdminController::class,'product_edit'])->name('admin.products.edit');
    Route::post('/admin/products/update/{id}',[AdminController::class,'product_update'])->name('admin.products.update');
    Route::delete('/admin/products/delete/{id}',[AdminController::class,'product_delete'])->name('admin.products.delete');

    //coupons
    Route::get('/admin/coupons',[AdminController::class,'coupons'])->name('admin.coupon');
    Route::get('/admin/coupons/add',[AdminController::class,'coupon_add'])->name('admin.coupon.add');
    Route::post('/admin/coupons/store',[AdminController::class,'coupon_store'])->name('admin.coupon.store');
    Route::get('/admin/coupons/edit/{id}',[AdminController::class,'coupon_edit'])->name('admin.coupon.edit');
    Route::post('/admin/coupons/update/{id}',[AdminController::class,'coupon_update'])->name('admin.coupon.update');
    Route::delete('/admin/coupons/delete/{id}',[AdminController::class,'coupon_delete'])->name('admin.coupon.delete');

    //admin orders
    Route::get('/admin/orders',[AdminController::class,('orders')])->name('admin.orders');
    Route::get('/admin/order/details/{order_id}',[AdminController::class,('order_details')])->name('admin.orders.details');

    //order details status
    Route::put('/admin/order/update-status',[AdminController::class,'update_order_status'])->name('admin.order.update.status');

    //slide
    Route::get('/admins/slides',[AdminController::class,'slides'])->name('admin.slides');
    Route::get('/admins/slides/add',[AdminController::class,'slide_add'])->name('admin.slide.add');
    Route::post('/admins/slides/store',[AdminController::class,'slide_store'])->name('admin.slide.store');
    Route::get('/admins/slides/edit/{id}',[AdminController::class,'slide_edit'])->name('admin.slide.edit');
    Route::post('/admins/slides/update/{id}',[AdminController::class,'slide_update'])->name('admin.slide.update');
    Route::delete('/admins/slides/delete/{id}',[AdminController::class,'slide_delete'])->name('admin.slide.delete');


    //admin contact
    Route::get('/admin/contacts',[AdminController::class,'contacts'])->name('admin.contacts');
    Route::delete('/admin/contacts/delete/{id}',[AdminController::class,'contacts_delete'])->name('admin.contacts.delete');

    //admin search
    Route::get('/admin/search',[AdminController::class,'search'])->name('admin.search');
});











