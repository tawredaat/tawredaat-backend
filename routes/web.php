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

use App\Models\Setting;

$languages = \Config::get('app.languages');
$locale = Request::segment(1); //fetches first URI segment
if($locale != 'ar')
    $locale = '';

Route::get('convert/{locale}', function ($locale) {
    session()->has('lang') ? session()->forget('lang') : '';
    if ($locale == 'en') {
        session()->put('lang', 'en');
       // $route = Route::current();
        $parsed = parse_url(url()->previous());
        $parsed = str_replace('/ar','',$parsed);
        return redirect(  $parsed['path'])->with(['lang_changed' => 1]);
    }
    else{
        session()->put('lang', 'ar');
        $parsed = parse_url(url()->previous());
        return redirect($locale . $parsed['path'])->with(['lang_changed' => 1]);
    }
    //return back()->with(['lang_changed'=>1]);
})->name('convert.lang');

Route::prefix($locale)->middleware(['Lang'])->group(function () {
    //*******Start User Authentication Routes....**//
    Route::get('/geidea/payment', function(){
        return view('geideaPayment');
    });
    Route::group(['prefix' => '/', 'namespace' => 'Auth'], function () {
        //login loutes
        Route::post('login', 'LoginController@login')->name('website.login');
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        //Registration Routes...
        Route::get('signup', 'RegisterController@showRegistrationForm')->name('website.signup');
        Route::post('register', 'RegisterController@register')->name('website.register');
        //Password Reset Routes...
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
        //Facebook auth
        Route::get('auth/redirect/{provider}', 'LoginController@redirect')->name('redirect.facebook');
        Route::get('callback/{provider}', 'LoginController@callback');
        //logout
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
    //*******End User Authentication Routes....**//

    Route::get('/', 'User\HomeController@home');
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        Route::get('/', 'HomeController@home')->name('home');
        Route::get('/en',function (){
            return redirect()->route('user.home');
        });
        Route::get('/ar',function (){
            return redirect()->route('user.home');
        });
        Route::get('/about-us', 'HomeController@about')->name('about');

        Route::get('/en/about-us',function (){
            return redirect()->route('user.about');
        });
        Route::get('/ar/about-us',function (){
            return redirect()->route('user.about');
        });
        /*Route::get('RFQ',function (){
            $setting = Setting::first();
            return view('User.rfq',compact('setting'));

        })->name('RFQ');*/
        Route::get('/blogs', 'HomeController@showblogs')->name('blogs');

        Route::get('/en/blogs',function (){
            return redirect()->route('user.blogs');
        });


        Route::get('/{blogtitle}/{id}/blog', 'HomeController@showsingleblog')->name('single');
        Route::get('/en/{blogtitle}/{id}/blog',function ($blogtitle,$id){
            return urldecode(redirect()->route('user.single',[$blogtitle,$id])) ;
        });

        Route::get('/contact-us', 'HomeController@contact')->name('contact');
        Route::get('/en/contact-us',function (){
            return redirect()->route('user.contact');
        });

        // Route::get('show-categories', 'HomeController@categories')->name('categories');
        // Route::get('/en/show-categories',function (){
        //     return redirect()->route('user.categories');
        // });

        Route::get('render-categories', 'HomeController@categoriesRender')->name('all.categories');
        Route::get('/en/render-categories',function (){
            return redirect()->route('user.all.categories');
        });
        //companies routes
        Route::get('show-companies', 'CompanyController@index')->name('companies');
        Route::get('/en/show-companies',function (){
            return redirect()->route('user.companies');
        });
        Route::get('{name}/{id}/c/', 'CompanyController@show')->name('company');
        Route::get('/en/company/{id}/{name}',function($id,$name){
           return urldecode(redirect()->route('user.company',['name'=>str_replace([' ','/'], '-',$name),'id'=>$id]));
        })->name('oldcompany');
        Route::get('filter-in-companies', 'CompanyController@filterCompanies')->name('filter-in-companies');
        Route::get('/en/filter-in-companies',function (){
            return redirect()->route('user.filter-in-companies');
        });

        Route::get('companies-by-categories/{name}/{id}', 'CompanyController@CompanyCategory')->name('CompanyCategory');
        Route::get('/en/companies-by-categories/{name}/{id}',function ($name,$id){
            return urldecode(redirect()->route('user.CompanyCategory',[$name,$id])) ;
        });
        Route::get('companies-by-tags/{id}', 'CompanyController@CompanyKeywords')->name('CompanyKeywords');
        Route::get('/en/companies-by-tags/{id}',function ($id){
            return redirect()->route('user.CompanyKeywords',[$id]);
        });
        Route::get('company/{id}/{name}/products/', 'CompanyController@companyProducts')->name('company-products');
        Route::get('/en/company/{id}/{name}/products/',function ($id,$name){
            return urldecode(redirect()->route('user.company-products',[$id,$name])) ;
        });
        //products routes
        Route::get('show-products', 'ProductController@index')->name('products');
        Route::get('/en/show-products',function (){
            return redirect()->route('user.products');
        });
        Route::get('{name}/{brand}/{id}/p', 'ProductController@show')->name('product');

        Route::get('/en/p/{brand}/{category/}/{id}/{name}',function ($brand,$category,$id,$name){

            return urldecode(redirect()->route('user.product',['name'=>str_replace([' ','/'], '-',$name),'brand'=>str_replace([' ','/'], '-',$brand),'id'=>$id]));

        });

        Route::get('filter-in-products', 'ProductController@filterProducts')->name('filter-in-products');


        Route::get('/en/filter-in-products',function (){
            return redirect()->route('user.filter-in-products');
        });
        //brands routes
        Route::get('show-brands', 'BrandController@index')->name('brands');
        Route::get('/en/show-brands',function (){
            return redirect()->route('user.brands');
        });
        Route::get('/{name}/{id}/b/', 'BrandController@show')->name('brand');
        Route::get('/en/brand/{id}/{name}',function ($id,$name){
            return urldecode(redirect()->route('user.brand',['name'=>str_replace([' ','/'], '-',$name),$id]));
        })->name('oldbrand');
        Route::get('filter-in-brands', 'BrandController@filterBrands')->name('filter-in-brands');
        Route::get('/en/filter-in-brands',function (){
            return redirect()->route('user.filter-in-brands');
        });
        Route::get('brands-by-categories/{name}/{id}', 'BrandController@BrandCategory')->name('BrandCategory');
        Route::get('/en/brands-by-categories/{name}/{id}',function ($name,$id){
            return urldecode(redirect()->route('user.BrandCategory',[$name,$id])) ;
        });
        Route::get('brands-by-tags/{id}', 'BrandController@BrandKeywords')->name('BrandKeywords');
        Route::get('/en/brands-by-tags/{id}',function ($id){
            return urldecode(redirect()->route('user.BrandKeywords',[$id])) ;
        });
        Route::get('/{name}-products/{id}/u/', 'BrandController@BrandProducts')->name('brand-products');
        Route::get('/en/brand/{id}/{name}/products',function ($id,$name){
            return urldecode(redirect()->route('user.brand-products',['name'=>str_replace([' ','/'], '_',$name),'id'=>$id]));
        });
        Route::get('{id}/{name}/distributors', function ($id,$name){

            return urldecode(redirect()->route('user.brand-companies',['name'=>str_replace([' ','/'], '_',$name),'id'=>$id]));

        });

        Route::get('/{name}-distributors/{id}','BrandController@BrandCompanies')->name('brand-companies');
        //search routes
        Route::get('search', 'SearchController@search')->name('search');
        Route::get('/en/search',function (){
            return redirect()->route('user.search');
        });
        //categories routes
        Route::get('/en/category1/{id}/{name}',function ($id,$name){
            return urldecode(redirect()->route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$name),'id'=>$id])) ;
        })->name('oldcategory1');
        Route::get('/en/category2/{id}/{name}',function ($id,$name){
            return urldecode(redirect()->route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$name),'id'=>$id])) ;
        })->name('oldcategory2');
        Route::get('/en/category3/{id}/{name}',function ($id,$name){
            return urldecode(redirect()->route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$name),'id'=>$id])) ;
        })->name('oldcategory3');
        Route::get('/{name}/{id}/l/', 'CategoryController@productsFilterByCategories')->name('filter-by-category1');
//        Route::get('/{id}/{name}/II/', 'CategoryController@productsFilterByCategories')->name('filter-by-category2');
//        Route::get('/{id}/{name}/III/', 'CategoryController@productsFilterByCategories')->name('filter-by-category3');

        Route::get('terms-and-conditions/c/', 'HomeController@termsConditions')->name('terms.conditions');
        Route::get('sell-with-us/c/', 'HomeController@sellPolicies')->name('sell.policies');
        Route::get('privacy-and-policy/c/', 'HomeController@privacyPolicy')->name('privacy.policy');
        //company actions
        Route::post('call-by-user', 'CompanyController@CallRequest')->name('company-call');
        Route::post('whatscall-by-user', 'CompanyController@whatsCallRequest')->name('company-whatsCall');
        Route::post('/en/call-by-user',function (){
            return redirect()->route('user.company-call');
        });
        Route::post('btns-clicks', 'CompanyController@BtnClick')->name('btns-click');
        Route::post('/en/btns-clicks',function (){
            return redirect()->route('user.btns-click');
        });
    });
    //Join us
    Route::get('/getlisted', 'User\HomeController@joinUs')->name('joinus');
    Route::get('/en/getlisted',function (){
        return redirect()->route('joinus');
    });
    Route::post('/join/us', 'User\HomeController@storeCompanyRequest')->name('store-joinus');
    Route::get('/en/join/us',function (){
        return redirect()->route('user.store-joinus');
    });
    Route::get('request-sent',function(){
        if(!session()->has('companyRequestSent') && !session()->has('RFQsent'))
            return redirect('/');
        return view('User.complate');
    })->name('user.request.sent');

    //Shop Products URLs//
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        Route::get('/shop','ShopProductController@shop')->name('shop.products');
        Route::get('{name}/{brand}/{id}/shop-product', 'ShopProductController@show')->name('shop.product');
        Route::get('/en/shop-product/{brand}/{category/}/{id}/{name}',function ($brand,$category,$id,$name){
            return urldecode(redirect()->route('user.shop.product',['name'=>str_replace([' ','/'], '-',$name),'brand'=>str_replace([' ','/'], '-',$brand),'id'=>$id]));

        });
        Route::get('/shop/categories/all', 'ShopProductController@viewAllL3Categories')->name('shop.categories.view.all');
        Route::get('/shop/categories/{id}/{name}', 'ShopProductController@filterShopCategory')->name('shop.filter.categories');
        Route::post('/shop/categories/{id}/{name}', 'ShopProductController@filterShopCategory')->name('shop.filter.categories');
        Route::get('/shop/products/c1/{id}/{name}', 'ShopProductController@getShopProductsByL1Category')->name('shop.category.l1.products');
        Route::post('/shop/products/c1/{id}/{name}', 'ShopProductController@getShopProductsByL1Category')->name('shop.category.l1.products');
        Route::get('/shop/products/c2/{id}/{name}', 'ShopProductController@getShopProductsByL2Category')->name('shop.category.l2.products');
        Route::get('/shop/products/c3/{id}/{name}', 'ShopProductController@getShopProductsByL3Category')->name('shop.category.l3.products');
        Route::get('filter-in-shop-products', 'ShopProductController@filterShopProducts')->name('filter-in-shop.products');
        Route::get('/en/filter-in-shop-products',function (){
            return redirect()->route('filter-in-shop.products');
        });
    });
    //authorized Routes for logged in usere
    Route::group(['middleware' => 'auth:web','namespace' => 'User', 'as' => 'user.'], function () {
    //settings
        Route::get('account/setting', 'UserController@settings')->name('account.settings');
        Route::get('/en/account/setting',function (){
            return redirect()->route('user.account.settings');
        });
        Route::post('save/account/settings/{id}', 'UserController@saveSettings')->name('setting');
        Route::post('/en/save/account/settings/{id}',function ($id){
            return redirect()->route('user.settings',[$id]);
        });
    //RFQ
        Route::get('/rfq', 'RfqController@rfq')->name('rfq');
        Route::post('/clone-categories', 'RfqController@clone')->name('clone-categories');
        Route::post('/send-rfq', 'RfqController@sendRfq')->name('send-rfq');
        Route::get('/rfq-list', 'RfqController@rfqList')->name('rfq.list');
        Route::get('/rfq-responses/{id}', 'RfqController@rfqResponses')->name('rfq.responses');
        Route::get('/rfq-response-accept/{id}', 'RfqController@Acceptrfq')->name('rfq.response.accept');
        Route::get('/rfq-response-refuse/{id}', 'RfqController@Refuserfq')->name('rfq.response.refuse');
    //product RFQ
        Route::post('/product-rfq', 'RfqController@sendProductRfq')->name('product-rfq');
        Route::get('/product-rfq-list', 'RfqController@productRfqList')->name('product.rfq.list');
        Route::post('/product-rfq-best-selling/{id}', 'RfqController@productRfqBestSelling')->name('product.rfq.best');
    //company actions
        Route::post('request-general-quotaion', 'CompanyController@requestGeneralQuotaion')->name('request-general-quotaion');
        Route::post('/en/request-general-quotaion',function (){
            return redirect()->route('user.request-general-quotaion');
        });
    //Cart module//
        Route::post('/cart/store','CartController@store')->name('add.cart');
        Route::post('/cart/update','CartController@update')->name('update.cart');
        Route::post('/cart/delete','CartController@delete')->name('delete.cart');
    //Checkout module//
        Route::get('/checkout/view-addresses', 'CheckoutController@addresses')->name('view.addresses');
        Route::post('checkout/select-address', 'CheckoutController@selectAddress')->name('select-address.checkout');
        Route::post('checkout/add-address', 'CheckoutController@addAddress')->name('add-address.checkout');
        Route::get('/checkout', 'CheckoutController@view')->name('view.checkout');
        Route::post('checkout/select-payment', 'CheckoutController@selectPayment')->name('select-payment.checkout');
        Route::get('/checkout/order-sent', 'CheckoutController@checkout')->name('send.checkout');
    //orders module//
        Route::get('/my-orders/view', 'OrderController@view')->name('view.myOrders');
        Route::get('/my-order/{order}/view', 'OrderController@show')->name('order.details');
    });
    //Cart module//
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        Route::post('/guest/cart/store','GuestCartController@store')->name('guest.add.cart');
        Route::post('/guest/cart/update','GuestCartController@update')->name('guest.update.cart');
        Route::post('/guest/cart/delete','GuestCartController@delete')->name('guest.delete.cart');
        Route::get('/cart','CartController@view')->name('view.cart');
    });
});


