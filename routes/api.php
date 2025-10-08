<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BannerCategoryController;
use App\Http\Controllers\Admin\BannerHomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DeliveryPricesController;
use App\Http\Controllers\Admin\ItemsController;
use App\Http\Controllers\Admin\Menu_DetailController as AdminMenu_DetailController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\MosulAuthController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\OrdersController as AdminOrdersController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\QuantityController as AdminQuantityController;
use App\Http\Controllers\Admin\Service_provider\AuthController as AdminService_providerAuthController;
use App\Http\Controllers\Admin\Service_providerAddressController as AdminService_providerAddressController;
use App\Http\Controllers\Admin\Service_providerController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Mosul\Auth\LoginController;
use App\Http\Controllers\Mosul\OrderController;
use App\Http\Controllers\Service_provider\AddressController as Service_providerAddressController;
use App\Http\Controllers\Service_provider\AuthController as Service_providerAuthController;
use App\Http\Controllers\Service_provider\Menu_DetailController;
use App\Http\Controllers\Service_provider\MenuController;
use App\Http\Controllers\Service_provider\QuantityController;
use App\Http\Controllers\Service_provider\ServicesController as Service_providerServicesController;
use App\Http\Controllers\testController;
use App\Http\Controllers\Users\AddressController;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\BannerCategoryController as UsersBannerCategoryController;
use App\Http\Controllers\Users\BannerHomeController as UsersBannerHomeController;
use App\Http\Controllers\Users\CardController;
use App\Http\Controllers\Users\CategoryController as UsersCategoryController;
use App\Http\Controllers\Users\CouponController as UsersCouponController;
use App\Http\Controllers\Users\DeliveryPricesController as UsersDeliveryPricesController;
use App\Http\Controllers\Users\FavoritesController;
use App\Http\Controllers\Users\ItemsController as UsersItemsController;
use App\Http\Controllers\Users\Menu_DetailController as UsersMenu_DetailController;
use App\Http\Controllers\Users\MenuController as UsersMenuController;
use App\Http\Controllers\Users\ordersController;
use App\Http\Controllers\Users\PaymentController as UsersPaymentController;
use App\Http\Controllers\Users\QuantityController as UsersQuantityController;
use App\Http\Controllers\Users\ServicesController as UsersServicesController;
use App\Http\Middleware\MyMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/////////////////////AdminAuth//////////////////////////////////////////
Route::prefix('/AdminAuth')
    ->controller(AdminAuthController::class)
    ->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
////////////////AdminCount//////////////////////////////////////////////

Route::prefix('/CountHome')
    ->controller(CountController::class)

    ->group(function () {
        Route::post('show', 'show');
    });
////////////////AdminOders///////////////////////////////////////////////
Route::prefix('/OrderHome')
    ->controller(AdminOrdersController::class)

    ->group(function () {
        Route::post('show', 'show');
        Route::post('OrderHistory', 'OrderHistory');

        Route::post('updateOrderStatus', 'updateOrderStatus');
        Route::post('search', 'search');

    });
//////////////////////////////////AdminBannerHome////////////////////////

Route::prefix('/BannerHome')
    ->controller(BannerHomeController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('updata', 'update');

        Route::post('Show', 'show');
        Route::post('destroy', 'destroy');

    });

///////////////////////AdminCategory///////////////////////////////

Route::prefix('/Category')
    ->controller(CategoryController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('Showca', 'index');
        // Route::post('showca', 'show');

        Route::post('updata', 'update');
        Route::post('destroy', 'destroy');
        Route::post('restore', 'restore');

    });

///////////////////////AdminBannerCategory///////////////////////////////
Route::prefix('/BannerCategory')
    ->controller(BannerCategoryController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('Showca', 'show');

        Route::post('updata', 'update');
        Route::post('destroy', 'destroy');

    });
////////////////////////////AdminItems///////////////////////////////////
Route::prefix('/Adminitems')
    ->controller(ItemsController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('Show', 'show');

        Route::post('add', 'store');
        Route::post('updata', 'update');
        Route::post('destroy', 'destroy');
        Route::post('restore', 'restore');
        Route::post('search', 'search');

    });
//////////////////////AdminService_Provider//////////////////////////
Route::prefix('/AdminService_Provider')
    ->controller(Service_providerController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('Show', 'show');
        Route::post('updata', 'update');
        Route::post('search', 'search');

    });
//////////////////////AdminServices/////////////////////////////////
Route::prefix('/AdminServices')
    ->controller(ServicesController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('Show', 'show');
        Route::post('add', 'store');
        Route::post('updata', 'update');
        Route::post('destroy', 'destroy');
        Route::post('restore', 'restore');
        Route::post('search', 'search');

    });
///////////////////AdminUsers//////////////////////
Route::prefix('/AdminUsers')
    ->controller(UsersController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('Show', 'show');
        Route::post('add', 'store');
        Route::post('updata', 'update');
        Route::post('search', 'search');

    });
//////////////////AdminCoupon/////////////////////////////////////////

Route::prefix('/AdminCoupon')
    ->controller(CouponController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('Show', 'show');
        Route::post('showstats', 'showstats');

        Route::post('add', 'store');
        Route::post('updata', 'update');
        Route::post('updatestatus', 'updatestatus');
        Route::post('destroy', 'destroy');
        Route::post('restore', 'restore');
        Route::post('search', 'search');

    });
/////////////////////AdminPayment////////////////////////////////////
Route::prefix('/AdminPayment')
    ->controller(PaymentController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('destroy', 'destroy');
        Route::post('Show', 'show');
        Route::post('restore', 'restore');

        Route::post('updata', 'update');

    });
//////////////////AdmindeliveryPrice//////////////////////////////////
Route::prefix('/deliveryPrice')
    ->controller(DeliveryPricesController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('updata', 'update');

    });
////////////////////////AdminService_providerAddress///////////////////
Route::prefix('/AddressService')

    ->controller(AdminService_providerAddressController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('updata', 'update');
        Route::post('Show', 'show');

    });
///////////AdminMenus///////////////////////////////////////////////
Route::prefix('/AdminMenus')
    ->controller(AdminMenuController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('showService', 'showService');

        Route::post('Show', 'show');
        Route::post('search', 'searchMenusByName');

        Route::post('updata', 'update');
        Route::post('destroy', 'destroy');
        Route::post('restore', 'restore');

    });

///////////AdminmenuDetail///////////////////////////////////////////
Route::prefix('/AdminmenuDetail')
    ->controller(AdminMenu_DetailController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('Show', 'show');
        Route::post('showMenu', 'showMenu');
        Route::post('search', 'searchMenuDetailsByName');
        Route::post('showmenu', 'showmenu');

        Route::post('add', 'store');
        Route::post('updata', 'update');
        Route::post('destroy', 'destroy');
        Route::post('restore', 'restore');

    });
////////////Adminquantitys/////////////////////////////////////////////

Route::prefix('/Adminquantitys')
    ->controller(AdminQuantityController::class)
    ->middleware('auth:sanctum') // هنا تضيف الـ middleware
    ->group(function () {
        Route::post('add', 'store');
        Route::post('updata', 'update');
        Route::post('Show', 'show');
        Route::post('showMenu_Detail', 'showMenu_Detail');

    });

//////////////////AdminMosulAuth////////////////////////////////
Route::prefix('/AdminMosulAuth')
    ->controller(MosulAuthController::class)
    ->group(function () {
        Route::post('register', 'register');
        Route::post('updata', 'update');
        Route::post('show', 'show');
        Route::post('search', 'search');

        Route::post('destroy', 'destroy');
        Route::post('restore', 'restore');

    });
//////////////////////AdminNotifications//////////////////////////////
Route::prefix('/AdminNotifications')
    ->controller(NotificationsController::class)
    ->group(function () {
      
        Route::post('Notifications', 'Notifications');

    });

//////////////////////UsersAuth////////////////////////////////////////

Route::prefix('/UserAuth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
/////////////UsersBanerHome////////////////////////////////
Route::prefix('/BannerHome')
    ->controller(UsersBannerHomeController::class)
    ->group(function () {
        Route::post('showAll', 'index');
    });
///////////////////////////////UsersCategory/////////////////////
Route::prefix('/Category')
    ->controller(UsersCategoryController::class)
    ->group(function () {
        Route::post('showAll', 'index');
    });
///////////////////////UsersBannerCategory///////////////////////////////
Route::prefix('/BannerCategory')
    ->controller(UsersBannerCategoryController::class)
    ->group(function () {
        Route::post('Show', 'show');

    });
//////////////////////////UsersItems//////////////////////////////////////
Route::prefix('/items')
    ->controller(UsersItemsController::class)
    ->group(function () {
        Route::post('Show', 'show');

    });

///////////////////////////////Usersservices///////////////////////////////

Route::prefix('/Services')
    ->controller(UsersServicesController::class)
    ->group(function () {
        Route::post('Show', 'show');

        Route::post('search', 'search');

    });
///////////////////////////UsersMenus///////////////////////////////////
Route::prefix('/Menu')
    ->controller(UsersMenuController::class)
    ->group(function () {
        Route::post('Show', 'show');

    });
/////////////////////UsersMenu_Detail///////////////////////////////////
Route::prefix('/Menu_Detail')
    ->controller(UsersMenu_DetailController::class)
    ->group(function () {
        Route::post('Show', 'show');

    });
///////////////////UsersQuantity///////////////////////////////////////
Route::prefix('/Quantity')
    ->controller(UsersQuantityController::class)
    ->group(function () {
        Route::post('Show', 'show');

    });
//////////////////UsersCard///////////////////////////////////////////////
Route::prefix('/Card')
    ->controller(CardController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('add', 'store');
        Route::post('Show', 'show');
        Route::post('showCartView', 'showCartView');

        Route::post('remove', 'decreaseQuantityByQuantityId');
        Route::post('removeAll', 'destroy');

    });
/////////////////UsersAddress///////////////////////////////////////////////
Route::prefix('/Address')
    ->controller(AddressController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('add', 'store');
        Route::post('update', 'update');
        Route::post('remove', 'destroy');
        Route::post('Show', 'show');

    });
///////////////Usersfavorites/////////////////////////////////////////////////
Route::prefix('/Favorite')
    ->controller(FavoritesController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('add', 'store');
        Route::post('Show', 'show');
        Route::post('remove', 'destroy');

    });
//////////////UsersCoupon///////////////////////////////////////////////////////
Route::prefix('/Coupon')
    ->controller(UsersCouponController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('Show', 'show');
        Route::post('remove', 'destroy');

    });
////////////////////UsersPayment//////////////////////////////////////////////////
Route::prefix('/Payment')
    ->controller(UsersPaymentController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('Show', 'show');
        Route::post('remove', 'destroy');

    });
///////////////////////UsersOrder///////////////////////////////////////
Route::prefix('/orders')
    ->controller(ordersController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('add', 'store');
        Route::post('Show', 'show');

    });
////////////////////////////UsersdeliveryPrice//////////////////////////////
Route::prefix('/deliveryPrice')
    ->controller(UsersDeliveryPricesController::class)
    ->group(function () {
        Route::post('Show', 'index');

    });
Route::prefix('/test')
    ->controller(testController::class)

    ->group(function () {
        Route::post('store', 'updateOrderStatus');

    });
////////////////MosulAuth////////////////////////////////
Route::prefix('/MosulAuth')
    ->controller(LoginController::class)
    ->group(function () {
        Route::post('login', 'login');

    });
////////////////MosulOrder////////////////////////////////
Route::prefix('/MosulOrder')
    ->controller(OrderController::class)
     ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('show', 'show');
        Route::post('showcoun', 'showcoun');
        Route::post('updateOrderStatus', 'updateOrderStatus');
        Route::post('OrderHistory', 'OrderHistory');

    });
