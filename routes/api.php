<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::namespace('User\Api')->middleware(['localization'])->group(function () {
    Route::post('/dayra-webhook', 'DayraWeebhookController@handleWebhook');
    Route::get('my/interests', 'AuthController@allInterests');
    Route::post('register/consumer', 'AuthController@register_consumer');
    Route::post('register/company', 'AuthController@register_company'); 
    Route::post('register/technician', 'AuthController@register_technician');

    Route::post('login', 'AuthController@login');
    //verify account
    Route::post('verify/account', 'AuthController@VerifyAccount')->name('verify.account');
    Route::post('resend/code', 'AuthController@resendVerify')->name('verify.resend');
    Route::get('verification/codes', 'AuthController@getVerifyCodes')->name('get.verify.codes');
    //forget passowrd
    Route::post('forget/password', 'AuthController@forgetPassword')->name('forget.password');
    //login using social accounts
    Route::post('login/provider', 'AuthController@loginProvider');

    Route::get('home', 'HomeController@index')->name('get.verify.codes');
    Route::get('homeBanners', 'HomeController@homeBanners')->name('get.home.banners');
    Route::get('recently-arrived/{id}', 'CategoryController@recentlyArrived')->name('category.recently.arrived');
    Route::get('best-seller/{id}', 'CategoryController@bestSeller')->name('category.best.seller');
    Route::get('categoryOffers/{id}', 'CategoryController@categoryOffers')->name('category.offers');
    Route::get('categoryBrands/{id}', 'CategoryController@categoryBrands')->name('category.brands');
    Route::get('category/level1/{id}', 'CategoryController@categoryLevelOne')->name('category.level.one');
    Route::get('category/level2/{id}', 'CategoryController@categoryLevelTwo')->name('category.level.two');
    Route::get('category/level3/{id}', 'CategoryController@categoryLevelThree')->name('category.level.three');
    Route::get('category-seo/{id}', 'CategoryController@categorySeo')->name('category.seo');
    Route::get('product-seo/{id}', 'ShopProductController@productSeo')->name('product.seo');
  	Route::get('bundel-seo/{id}', 'BundelController@bundelSeo')->name('bundel.seo');
  	Route::get('brand-seo/{id}', 'BrandController@brandSeo')->name('brand.seo');
  	Route::get('home-seo', 'HomeController@homeSeo')->name('home.seo');
  	Route::get('brands-seo', 'BrandController@brandsSeo')->name('brands.seo');
    Route::get('offers-seo', 'CategoryController@offerSeo')->name('offers.seo');
    Route::get('bundels-seo', 'BundelController@bundelsSeo')->name('bundels.seo');
    Route::get('category/level3/products_count/{id}', 'CategoryController@categoryLevelThreeProductsCount')->name('category.level.three.products.count');
    Route::get('category/level3/filter/{id}', 'CategoryController@categoryLevelThreeFilterList')->name('category.level.three.filter.list');
    Route::get('offerBanner', 'CategoryController@offerBanner')->name('category.offers');

  	Route::get('dynamic-pages', 'DynamicPageController@dynamicPages');
    Route::get('dynamic-page/details/{id}', 'DynamicPageController@pageDetails');
    Route::get('dynamic-page/seo/{slug}', 'DynamicPageController@pageSeo');

    Route::get('category/bundels/{id}', 'BundelController@categoryBundels')->name('category.bundels');
    Route::get('bundels/banner/', 'BundelController@bundelBanner')->name('bundels.banner');
    Route::get('bundel/details/{id}', 'BundelController@bundelDetails')->name('bundel.details');
    
    Route::get('payment/notes/', 'PaymentNoteController@list')->name('payment.notes');

    Route::get('countries', 'HomeController@countries');

    Route::get('rfq/categories', 'RfqController@level3categories');
    Route::get('promo-details/{code}', 'CartController@promoDetails');

    Route::get('shop', 'ShopProductController@shop');
    Route::get('shop/product/{id}', 'ShopProductController@show');
    Route::get('shop/category/products/{id}', 'ShopProductController@getShopProductsByL3Category');
    Route::get('shop/categories/', 'ShopProductController@allLevel1');
    Route::get('shop/filter/products', 'ShopProductController@filter');
    //new
    Route::get('shop/l3/categories/{id}', 'ShopProductController@shopCategories');
    //new
    Route::get('terms-and-conditions', 'HomeController@termsConditions');
    Route::get('faq', 'PolicyController@faqs');
    Route::get('privacy-and-policy', 'HomeController@privacyPolicy');
    Route::get('sell-policy', 'HomeController@sellPolicies');
    Route::get('settings', 'HomeController@settings');

    Route::get('refund-and-returns-policy', 'RefundAndReturnsPolicyController');

    Route::get('/searchByProduct', 'HomeController@searchByProduct');
  	Route::get('/searchByProductCount', 'HomeController@searchByProductCount');
    Route::get('/searchByBrand', 'HomeController@filterProductsByBrand');

    
    Route::group(['prefix' => 'user/home'], function () {
        Route::get('/ad/banners', 'HomeController@adBanners');
        Route::get('/banners', 'HomeController@banners');
        Route::get('/featured/categories', 'HomeController@featuredCategories');
        Route::get('/featured/companies', 'HomeController@featuredCompanies');
        Route::get('/featured/brands', 'HomeController@featuredBrands');
    });

    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', 'BlogController@index');
        Route::get('/show/{id}', 'BlogController@show');
    });

    Route::group(['prefix' => 'companies'], function () {
        Route::post('/search', 'CompanyController@search');
        Route::get('/', 'CompanyController@view');
        Route::get('/show/{id}', 'CompanyController@show');
    });

    Route::group(['prefix' => 'brands'], function () {
        Route::post('/search', 'BrandController@search');
        Route::get('/', 'BrandController@view');
        Route::get('/show/{id}', 'BrandController@show');
        Route::get('/distributes/{id}', 'BrandController@distributes');
        Route::get('brand/show/{id}', 'BrandController@showDetails');
    });

    // Route::get('/categories-brands', 'CategoryBrandController@index');
    Route::group(['prefix' => 'categories-brands'], function () {
        Route::get('/', 'CategoryBrandController@index');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::post('/search', 'ProductController@search');
        Route::get('/', 'ProductController@view');
        Route::get('/show/{id}', 'ProductController@show');
        Route::get('/company/{id}', 'ProductController@companyProducts');
        Route::get('/brand/{id}', 'ProductController@brandProducts');
        Route::get('/category/{id}/{level}', 'ProductController@categoryProducts');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@allLevel1')->name('all.level1');
        Route::get('/view-category-level-1', 'CategoryController@viewLevel1Category')
            ->name('view-category-level-1');
        Route::get('category/show/{id}', 'CategoryController@show');
        Route::get('categoryDetails/{id}', 'CategoryController@categoryDetails');
        Route::get('categoriesLOne/' , 'categoryController@listLOne');

    });

    Route::group(['prefix' => 'user/shop/products'], function () {
        Route::get('/', 'ShopProductController@shop');
        Route::get('/show/{id}', 'ShopProductController@show');
    });

    Route::post('sucess/{user}', 'Payment\PaymentController@sucess')->name('paytabs.sucess');
    Route::post('failed/{user}', 'Payment\PaymentController@failed')->name('paytabs.failed');

    Route::get('user/get-profile/{user_id}', 'UserController@getProfile');

    Route::post('track-order', 'TrackOrderController');

    Route::post('survey', 'SurveyController');

    Route::group(['prefix' => 'guest-users'], function () {
        Route::post('store', 'GuestUserController@store');
    });

    // paymob payment routes
    Route::group(['prefix' => 'paymob'], function () {
        Route::post('post-state', 'Payment\PayMobPaymentController@processedCallback');
    });

    //site map route
    Route::get('site-map', 'SiteMapController');
    
    Route::group(['prefix' => 'user'], function () {
        Route::group(['prefix' => 'rfqs'], function () {
            Route::post('store', 'UserRfqController@store');
        });
    });
    
    Route::group(['prefix' => 'user'], function () {
        Route::group(['prefix' => 'suppliers'], function () {
            Route::post('store', 'SupplierController@store');
        });
    });
    
    // Logged in routes
    Route::middleware('auth:sanctum')->group(function () {

        Route::group(['prefix' => 'user/cart'], function () {
            Route::get('/view', 'CartController@view');
            Route::post('/add', 'CartController@store');
            Route::post('/update', 'CartController@update');
            Route::post('/delete/{id}', 'CartController@delete');
            Route::post('/bundel/delete/{id}', 'CartController@deleteBundel');
            Route::post('/empty', 'CartController@empty');
            Route::post('/apply-promo-code', 'CartController@applyPromoCode');
        });

        Route::group(['prefix' => 'user/checkout'], function () {
            Route::get('/list/payments', 'CheckoutController@viewPayments');
            Route::post('/select/payment', 'CheckoutController@selectPayment');
            Route::post('/', 'CheckoutController@checkout');
        });

        // paymob payment routes
        Route::group(['prefix' => 'paymob'], function () {
            Route::post('pay/{order_id}', 'Payment\PayMobPaymentController@pay');
            // souqelkahraba.com/stage/public/api/paymob/state
            Route::get('state', 'Payment\PayMobPaymentController@responseCallback');
        });

        // paytabs payment routes
        Route::group(['prefix' => 'paytabs'], function () {
            Route::get('pay', 'Payment\PaymentController@pay');
            Route::get('checkTransaction/{tran_ref}', 'Payment\PaymentController@checkTransaction');
        });

        // old payments
        Route::group(['prefix' => 'geidea'], function () {
            Route::get('pay', 'Payment\GeideaPaymentController@pay')->name('geidea.pay');
            Route::post('sucess', 'Payment\GeideaPaymentController@sucess')->name('geidea.sucess');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::post('update/profile', 'UserController@updateProfile');

            Route::get('profile', 'UserController@showProfile');
            // used by the front-end developer only

            Route::post('change/password', 'UserController@changePassword');
            Route::post('select/interests', 'UserController@selectInterests');
            Route::get('notifications', 'UserController@getNotifications');
            Route::post('update/firebase/token', 'Notifications\UpdateFirebaseTokenController');
            Route::get('send/test/notification', 'UserController@sendNotification');

            Route::group(['prefix' => 'checkout'], function () {
                Route::post('/select/address', 'CheckoutController@selectAddress');
            });

            Route::group(['prefix' => 'addresses'], function () {
                Route::get('/', 'UserController@viewAddresses');
                Route::post('store', 'UserController@addAddress');
                Route::post('update/{id}', 'UserController@updateAddress');
                Route::post('delete/{id}', 'UserController@deleteAddress');
                Route::post('select', 'UserController@selectAddress');
                Route::post('set-default', 'UserController@setDefault');
            });

            Route::group(['prefix' => 'rfq'], function () {
                Route::get('/', 'RfqController@view');
                Route::post('send', 'RfqController@send');
                Route::get('accept/{id}', 'RfqController@accept');
                Route::get('reject/{id}', 'RfqController@reject');
                Route::get('show/{id}', 'RfqController@companyResponse');
                Route::post('best/selling/products/price/{id}', 'RfqController@productRfqBestSelling');
            });

            Route::group(['prefix' => 'rfqs'], function () {
                Route::get('/', 'UserRfqController@index');
                // Route::post('store', 'UserRfqController@store');
                Route::post('respond', 'UserRfqController@respond');
                Route::get('show/{id}', 'UserRfqController@show');
            });

            Route::group(['prefix' => 'orders'], function () {
                Route::get('/', 'OrderController@view');
                Route::get('/view/{order}', 'OrderController@show');
                Route::get('/view/{order}', 'OrderController@show');
                Route::get('/view-paid-online', 'OrderController@showPaidOnline');
                Route::get('/view-order-details/{id}', 'OrderController@viewOrderPaidDetails');
                Route::post('client-approved-order/{id}',
                    'OrderController@clientApprovedOrder')->name('client-approved-order');

            });
        });
        //user interests
        Route::group(['prefix' => 'user/interests'], function () {
            Route::get('/view', 'UserController@viewInterests');
        });

        Route::get('/logout', 'AuthController@logout');
    });
});
