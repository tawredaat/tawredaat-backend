<?php



use App\Http\Controllers\Admin\BannerController;

use App\Mail\User\Order\OrderUpdated;

use App\Models\Order;

use App\Models\Setting;

use App\Models\ShopProduct;

use App\Models\ShopProductSpecification;

use App\Http\Controllers\Admin\ShopProductController;

use App\Models\ShopProductSpecificationTranslation;

use App\Models\Specification;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;



// test emails

Route::get('view-email', function () {

    $setting = Setting::first();

    $logo = $setting->site_logo;

    // $logo = asset('images/logo.png');



    $app_name = config('global.used_app_name');

    $order = Order::find(192);

    return view('User.mails.order.received', compact('order', 'app_name', 'logo'));
});



//update product slug 

Route::get('/update-slug', function () {

    set_time_limit(0);

    ini_set('memory_limit', '-1');

    $shopProducts = ShopProduct::with('translations')->get();

    foreach ($shopProducts as $shopProduct) {

        if (!$shopProduct->slug) {

            $shopProduct->update([

                'en' => [

                    'slug' =>  Str::slug($shopProduct->translate('en')->name)

                ],

                'ar' => [

                    'slug' =>  slugInArabic($shopProduct->translate('ar')->name)

                ]

            ]);
        }
    }
});





// handel product specification values 

Route::get('/handle-productSpecificationValues', function () {

    set_time_limit(0);

    ini_set('memory_limit', '-1');

    $specifications = Specification::pluck('id')->toArray();

    // dd($specifications);

    foreach ($specifications as $value) {

        // dd($value);

        $shopProductSpecifications = ShopProductSpecification::where('specification_id', $value)->get();

        foreach ($shopProductSpecifications as $shopProductSpecification) {

            $value = ShopProductSpecification::where('id', $shopProductSpecification->id)->pluck('value')->first();



            if (strlen($value) == 0 && strlen($shopProductSpecification->value) > 0) {

                DB::table('shop_product_specifications')

                    ->where('id', $shopProductSpecification->id)

                    ->update(['value' => $shopProductSpecification->value]);
            } elseif (strlen($value) > 0) {



                $result = ShopProductSpecificationTranslation::where('shop_product_specification_id', $shopProductSpecification->id)->first();

                if (!$result) {

                    $shopProductSpecification->update([

                        'en' => [

                            'value' => $value

                        ],

                        'ar' => [

                            'value' => $value

                        ]

                    ]);
                }
            } else

                continue;
        }
    }
});







Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {



    // test emails

    Route::get('view-email', function () {

        $order = Order::toSendEmail()->find(170);

        return new OrderUpdated($order);
    });



    Route::get('login', 'AdminAuthenticationController@login')->name('admin.login');

    Route::post('login', 'AdminAuthenticationController@checkLogin')->name('admin.login');

    //Change default guard ('web') to admin guard

    Config::set('auth.defines', 'admin');

    /*

    -check super middleware admin using admin guard

    -super admin priviliges

     */



    Route::group(['middleware' => 'super:admin'], function () {



        Route::prefix('brand-store-banners')->group(function () {

            Route::as('brand-store-banners.')->group(function () {

                Route::get('/', 'BrandStoreBannerController@index')->name('index');

                Route::post('store', 'BrandStoreBannerController@store')->name('store');

                Route::post('update/{id}', 'BrandStoreBannerController@update')->name('update');
            });
        });



        Route::resource('categories-brands-store-pages', 'CategoryBrandStorePageController')->except(['show']);

        Route::prefix('categories-brands-store-pages')->group(function () {

            Route::as('categories-brands-store-pages.')->group(function () {

                // data

                Route::get('data', 'CategoryBrandStorePageController@data')->name('data');
            });
        });

		Route::resource('suppliers', 'SupplierController');

        /**

         * Vendors Module Routes

         */

        Route::resource('vendors', 'VendorController')->except(['show']);

        Route::prefix('vendors')->group(function () {

            Route::as('vendors.')->group(function () {

                // data

                Route::get('data', 'VendorController@data')->name('data');

                Route::post('approve', 'VendorController@approve')->name('approve');

                // approve-selected approve-all

            });
        });



        /**

         * Vendor Shop Products Module Routes

         */



        // Route::resource('vendor-shop-products', 'VendorShopProductController')->except(['show']);

        Route::prefix('vendor-shop-products')->group(function () {

            Route::as('vendor-shop-products.')->group(function () {

                Route::get('all/{vendor_id}', 'VendorShopProductController@index')

                    ->name('index');

                Route::get('data', 'VendorShopProductController@data')->name('data');

                Route::post('approve', 'VendorShopProductController@approve')->name('approve');

                Route::post(

                    'approve-selected',

                    'VendorShopProductController@approveSelected'

                )->name('approve-selected');

                Route::post(

                    'approve-all',

                    'VendorShopProductController@approveAll'

                )->name('approve-all');
            });
        });



        //home

        Route::get('/', 'AdminAuthenticationController@home')->name('admin.home');

        //admin resource controller

        Route::resource('admins', 'AdminController');

        Route::get('admin/view', 'AdminController@admins')->name('admin.admins');

        // valid-super-password

        Route::post('admin/valid-super-password', 'AdminController@validSuperAdminPassword')

            ->name('admin.valid-super-password');



        //notifications

        Route::get('notifications/create', 'NotificationController@create')->name('notifications.create');

        Route::get('notifications/view', 'NotificationController@index')->name('notifications.view');

        Route::post('notifications/send', 'NotificationController@send')->name('notifications.send');

        //Unit Controller

        Route::resource('units', 'UnitController');

        Route::get('unit/view', 'UnitController@units')->name('unit.units');

        //area Controller

        Route::resource('areas', 'AreaController');

        Route::get('area/view', 'AreaController@areas')->name('area.areas');

        //RFQs Controller

        Route::get('user-rfqs/list', 'RfqController@index')->name('admins.rfqs.index');

        Route::get('user-rfq/{id}/show', 'RfqController@show')->name('admins.rfqs.show');

        Route::post('user-rfq/respond', 'RfqController@respond')->name('admins.rfqs.respond');

        Route::get('user-rfq/reject/{id}', 'RfqController@reject')->name('admins.rfqs.reject');
        
      	Route::get('user-rfq/approve/{id}', 'RfqController@approve')->name('admins.rfqs.approve');

        Route::get('user-rfq-export', 'RfqController@export')->name('admins.rfqs.export');



        //country Controller

        Route::resource('countries', 'CountryController')->except('show');

        Route::get('countries/view', 'CountryController@countries')->name('countries.countries');

        // blog Controller

        Route::resource('blogs', 'BlogController');

        Route::get('blog/view', 'BlogController@blogs')->name('blogs.blogs');

        //promocode Controller

        Route::resource('promocodes', 'PromocodeController')->except('show');

        Route::get('promocodes/view', 'PromocodeController@promocodes')->name('promocodes.promocodes');

        //payments Controller

        Route::resource('payments', 'PaymentController')->except('show');
        Route::resource('payment_notes', 'PaymentNoteController')->except('show');
        Route::get('payment_notes/view', 'PaymentNoteController@notes')->name('payment_notes.notes');

        Route::get('payments/view', 'PaymentController@payments')->name('payments.payments');
        Route::get('payments/changeStatus/{id}', 'PaymentController@changeStatus')->name('payments.changeStatus');


        //interests Controller

        Route::resource('interests', 'InterestController')->except('show');

        Route::get('interests/view', 'InterestController@interests')->name('interests.interests');

        //users Controller

        Route::resource('users', 'UserController')->except('show');

        Route::get('user/view', 'UserController@users')->name('user.users');
        Route::get('/dayra/users/', 'DayraController@listUser')->name('dayra.users');
        Route::get('/dayra/user-details/{uuid}', 'DayraController@userDetails')->name('dayra.user.details');
        Route::get('/dayra/user-details/{uuid}', 'DayraController@userDetails')->name('dayra.user.details');
        Route::get('/dayra/user-limit/{uuid}', 'DayraController@userLimitDetails')->name('dayra.user.limit');
        Route::get('/dayra/inventory-limit/{uuid}/{amount}', 'DayraController@userInventoryFinance')->name('dayra.inventory.limit');
        Route::get('/dayra/loan-options/{uuid}', 'DayraController@getLoanOptions')->name('dayra.loan.options');
        Route::post('/dayra/loan-request/{uuid}', 'DayraController@requestLoan')->name('dayra.loan.request');

        Route::prefix('users')->group(function () {

            Route::as('users.')->group(function () {

                Route::get('user/search', 'UserController@searchByName')

                    ->name('search-by-name');



                Route::get('address', 'UserController@address')

                    ->name('address');
                Route::get('users/export/{type}', 'UserController@exportUser')->name('users.export');
            });
        });



        //Company Type Controller

        Route::resource('company_types', 'CompanyTypeController')->except('show');
	
        Route::get('company_type/view', 'CompanyTypeController@company_types')->name('company_types.company_types');

        //orders

        Route::get('orders', 'OrderController@index')->name('orders.index');

        Route::get('orders/data/table', 'OrderController@data')->name('orders.data.table');

        Route::get('orders/show/{id}', 'OrderController@show')->name('orders.show');

        Route::post('orders/cancel/{id}', 'OrderController@cancel')->name('orders.cancel');

        Route::post('orders/change/status/{id}', 'OrderController@changeStatus')->name('orders.change.status');

        Route::get('orders/export', 'OrderController@export')->name('orders.export');

        Route::get('orders/export/details', 'OrderController@exportDetails')->name('orders.details.export');



        Route::prefix('orders')->group(function () {

            Route::as('orders.')->group(function () {

                Route::post(

                    'orders/add-product/{id}',

                    'OrderController@addProduct'

                )->name('add-product');



                Route::get(

                    'create',

                    'OrderController@create'

                )->name('create');



                Route::post(

                    'store',

                    'OrderController@store'

                )->name('store');



                Route::post(

                    'update/{id}',

                    'OrderController@update'

                )->name('update');
            });
        });



        //cancelled orders

        Route::get('orders/cancelled', 'CancelledOrderController@index')->name('orders.cancelled.index');

        Route::get('orders/cancelled/data/table', 'CancelledOrderController@data')->name('orders.cancelled.data.table');

        Route::get('orders/cancelled/show/{id}', 'CancelledOrderController@show')->name('orders.cancelled.show');

        //orders statuses

        Route::resource('order_statuses', 'OrderstatusController')->except('show');

        Route::get('order_statuses/view', 'OrderstatusController@order_statues')->name('order_statuses.order_statuses');

        //Product Specs Controller

        Route::resource('productSpecs', 'ProductSpecsController');

        Route::get('product/specs/view', 'ProductSpecsController@products')->name('product.specs');

        //Quantity types Controller

        Route::resource('quantityTypes', 'QuantityTypesController');

        Route::get('quantity/types/view', 'QuantityTypesController@quantities')->name('quantity.types');



        //Categories Controller

        Route::resource('categories', 'CategoryController')->except('show');

        Route::get('category/parents/view', 'CategoryController@level1s')->name('category.categories');

        Route::get('categories/level3/view', 'CategoryController@allLevel3')->name('categories.level3.index');

        Route::get('category/level2s/{id}', 'CategoryController@level2s')->name('category.categories.level2s');

        Route::get('category/level3s/{id}', 'CategoryController@level3s')->name('category.categories.level3s');

        Route::get('category/homeBanners', 'CategoryController@homeBannersCreate')->name('category.categories.homeBanners');

        Route::get('category/{category_id}/topBrands', 'CategoryController@topBrandsCreate')->name('category.topBrands.create');

        Route::post('category/topBrands/store', 'CategoryController@topBrandStore')->name('category.topBrands.store');

        Route::post('category/topBrands/update', 'CategoryController@topBrandUpdate')->name('category.topBrands.update');

        Route::get('category/{category_id}/topCategories', 'CategoryController@topCategoriesCreate')->name('category.topCategories.create');

        Route::post('category/topCategories/store', 'CategoryController@topCategoriestore')->name('category.topCategories.store');

        Route::post('category/topCategories/update', 'CategoryController@topCategoriesUpdate')->name('category.topCategories.update');

        Route::post('make/category/featured/{id}', 'CategoryController@makeFeatured')

            ->name('categories.featured');

        Route::post('make/category/show/{id}', 'CategoryController@showCategory')

            ->name('categories.showCategory');

        Route::prefix('categories')->group(function () {

            Route::as('categories.')->group(function () {

                Route::get(

                    'create-level-1',

                    'CategoryController@createLevel1'

                )->name('create-level-1');



                Route::post(

                    'store-level-1',

                    'CategoryController@storeLevel1'

                )->name('store-level-1');



                // destroy-level-1

                Route::post(

                    'destroy-level-1/{id}',

                    'CategoryController@destroyLevel1'

                )->name('destroy-level-1');
            });
        });



        Route::resource('category-banners', 'CategoryBannerController')->except('show');

        Route::post('make/categorybanner/home/{id}', 'CategoryBannerController@makeHome')

            ->name('categoriesBanners.home');

        Route::get('category-banners-view/{category_id}', 'CategoryBannerController@banners')

            ->name('category-banners-view');



        // Brands Controller

        Route::resource('brands', 'BrandController');

        Route::get('brand/view', 'BrandController@brands')->name('brand.brands');

        Route::post('make/brand/featured/{id}', 'BrandController@makeFeatured')->name('brands.featured');

        Route::post('make/brand/show/{id}', 'BrandController@toggleShow')->name('brands.show');

        Route::get('brand/companies/requests', 'BrandController@CompaniesRequests')->name('brand.CompaniesRequests');

        Route::post('brand/approve/Company/Brand/Type', 'BrandController@approveBrandType')->name('brand.approve.companyBrand');

        Route::post('brand/reject/Company/Brand/Type', 'BrandController@rejectBrandType')->name('brand.reject.companyBrand');

        Route::post('brand/update/rank/point', 'BrandController@RankPoint')->name('rank.point.brand.update');



        Route::resource('brand-banners', 'BrandBannerController')->except('show');

        Route::get('brand-banners-view/{brand_id}', 'BrandBannerController@banners')

            ->name('brand-banners-view');

        Route::get('/export-product-brand', 'BrandController@exportProductBrand')->name('exportProductBrand');
      	Route::get('/export-all-products', 'ShopProductController@exportAllProducts')->name('exportAllProducts');
        Route::post('/import-product-brand', 'BrandController@importProductBrand')->name('importProductBrand');



        //********* Start Products ********************

        Route::resource('products', 'ProductController');

        Route::get('product/view', 'ProductController@products')->name('product.products');

        Route::get('product/new/index', 'ProductController@getProducts')->name('products.new.index');

        Route::get('product/view/specifications/{id}', 'ProductController@specifications')->name('products.view.specifications');



        //Multiple image of single product

        Route::get('product/images/{id}', 'ProductController@viewImages')->name('products.images');

        Route::get('products/images/{id}', 'ProductController@ProductsImages')->name('product.images.view');

        Route::any('product/deleteImage/{id}/', 'ProductController@deleteImage')->name('products.deleteImage');

        Route::any('product/deleteSelectedImage/', 'ProductController@deleteSelectedImage')->name('products.delete.selected.image');



        Route::post('product/uploadImages/{id}', 'ProductController@uploadImages')->name('products.uploadImages');

        //Multiple image of single product



        //mas upload products

        Route::get('product/import/csv', 'ProductController@import')->name('products.import.csv');

        Route::post('product/delete/selected', 'ProductController@deleteSelected')->name('products.delete.selected');

        Route::post('product/delete/all', 'ProductController@deleteAll')->name('products.delete.all');



        Route::post('product/import/csv', 'MassUploadProductsController')->name('products.import');

        //upload multiple image

        Route::get('product/upload/images', 'MassUploadImageProductsController@upload')->name('products.upload.image');

        Route::post('product/upload/images', 'MassUploadImageProductsController@store')->name('products.upload');

        Route::get('product/uploaded/images', 'MassUploadImageProductsController@view')->name('product.uploaded.images');

        Route::any('delete/uploaded/images{id}', 'MassUploadImageProductsController@delete')->name('ProductsImages.delete');

        //upload multiple PDF

        Route::get('product/upload/PDFs', 'MassUploadPDFProductController@upload')->name('products.upload.PDF');

        Route::post('product/upload/PDFs', 'MassUploadPDFProductController@store')->name('products.PDFs.upload');

        Route::get('product/uploaded/PDFs', 'MassUploadPDFProductController@view')->name('product.uploaded.PDFs');

        Route::any('delete/uploaded/PDFs{id}', 'MassUploadPDFProductController@delete')->name('ProducstPDFs.delete');



        //*********End products **************

        Route::group(['prefix' => 'specification', 'as' => 'specification.value.'], function () {

            Route::get('/edit/{product_id}/{specification_id}', 'SpecificationController@edit')->name('edit');

            Route::post('/update', 'SpecificationController@update')->name('update');
        });
		
      	Route::resource('dynamic-page', DynamicPageController::class)->except('show');
        Route::get('dynamic-page/index', 'DynamicPageController@getDynamicPages')->name('dymanic-page.index');
        Route::post('dynamic-page/show/{id}', 'DynamicPageController@toggleshow')->name('dymanic-page.show');
      
        Route::resource('bundels', 'BundleController');
        Route::post('bundel/hide/{id}', 'BundleController@hide')->name('bundel.hide');
        Route::get('bundel/new/index', 'BundleController@getBundels')->name('bundel.new.index');
        Route::post('bundel/delete/selected', 'BundleController@deleteSelected')->name('bundels.delete.selected');
        Route::post('bundel/delete/all', 'BundleController@deleteAll')->name('bundels.delete.all');
        Route::get('bundel/shop-products/{id}', 'BundleController@shopProducts')->name('bundels.shop.products');
        Route::delete('bundel/shop-product/delete/{id}', 'BundelShopProductController@destroy')->name('bundels.shop.product.delete');
        Route::get('bundel/shop-product/create/{id}', 'BundelShopProductController@create')->name('bundels.shop.product.add');
        Route::post('bundel/shop-product/store/', 'BundelShopProductController@store')->name('bundels.shop.product.store');
        Route::get('bundel/shop-product/search/', 'BundelShopProductController@search')->name('bundels.shop.product.search');
        Route::post('bundel/shop-product/update-qty/{id}', 'BundelShopProductController@updateQty')->name('bundels.shop.product.updateQty');
        Route::post('bundel/show/{id}', 'BundleController@toggleshow')->name('bundels.show');
        Route::get('bundel/banner/view', 'BundleController@banners')->name('admin.bundel.banners');
        Route::get('bundel/banners/', 'BundleController@bundelBannerIndex')->name('bundel.banners.index');
        Route::get('bundel/banners/create/', 'BundleController@createBanner')->name('bundel.banners.create');
        Route::post('bundel/banners/store', 'BundleController@storeBanner')->name('bundel.banners.store');

		//seo routes 
        Route::resource('seo', 'SeoController')->only(['index' , 'edit' , 'update' , 'destroy']);
      	Route::get('seo/all', 'SeoController@seos')->name('seo.all');

        //mas upload products
        Route::get('bundel/import/csv', 'BundleController@import')->name('bundels.import.csv');
        Route::post('bundel/import/csv', 'BundelMassUpload')->name('bundels.import');


        //*********Start Shop products *************

        Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {

            Route::resource('products', 'ShopProductController');

            Route::get('product/update/prices', 'ShopProductController@updatePrices')->name('products.update.prices');

            Route::post('product/update/prices', 'ShopProductController@updatePricesExcel')->name('products.update.prices');

            Route::get('product/update/quantities', 'ShopProductController@updateQuantities')->name('products.update.quantities');

            Route::post('product/update/quantities', 'ShopProductController@updateQuantitiesExcel')->name('products.update.quantities');



            Route::get('product/view', 'ShopProductController@products')->name('product.products');

            Route::get('product/new/index', 'ShopProductController@getProducts')->name('products.new.index');

            Route::get('product/view/specifications/{id}', 'ShopProductController@specifications')->name('products.specifications');

            Route::post('make/product/featured/{id}', 'ShopProductController@toggleFeatured')->name('products.featured');

            Route::post('make/product/show/{id}', 'ShopProductController@toggleshow')->name('products.show');



            Route::post('product/delete/selected', 'ShopProductController@deleteSelected')

                ->name('products.delete.selected');

            Route::post('product-delete-filtered', 'ShopProductController@deleteFiltered')

                ->name('products.delete.filtered');

            Route::post('product/show/selected', 'ShopProductController@showSelected')

                ->name('products.show.selected');

            Route::post('product/hide/selected', 'ShopProductController@hideSelected')

                ->name('products.hide.selected');



            Route::post('product/delete/all', 'ShopProductController@deleteAll')->name('products.delete.all');

            Route::get('offers/products/view', 'ShopProductController@viewOffers')->name('offers.products.index');

            Route::get('offers/products/get', 'ShopProductController@getOffers')->name('offers.products');

            Route::post('product/delete/all/offers', 'ShopProductController@deleteAllOffers')->name('products.delete.all.offers');

            Route::post('product/remove/from/offers/{id}', 'ShopProductController@removeFromOffer')->name('products.remove.fromOffers');



            //Multiple image of single product

            Route::get('product/images/{id}', 'ShopProductController@viewImages')->name('products.images');

            Route::get('products/images/{id}', 'ShopProductController@ProductsImages')->name('product.images.view');

            Route::any('product/deleteImage/{id}/', 'ShopProductController@deleteImage')->name('products.deleteImage');

            Route::any('product/deleteSelectedImage/', 'ShopProductController@deleteSelectedImage')

                ->name('products.delete.selected.image');

            Route::post('product/uploadImages/{id}', 'ShopProductController@uploadImages')->name('products.uploadImages');

            //Multiple image of single product



            //mas upload products

            Route::get('product/import/csv', 'ShopProductController@import')->name('products.import.csv');

            Route::post('product/import/csv', 'ShopProductMassUpload')->name('products.import');



            Route::get('product/upload/update-details', 'ShopProductController@updateProductDetails')->name('products.update.details');

            Route::post('product/upload/update-details', 'ShopProductMassUpdateDetailsController')->name('products.update.details');

            Route::get('product/upload/update-offers', 'ShopProductController@updateOffers')->name('products.update.offers');

            Route::post('product/upload/update-offers', 'ShopProductMassUpdateOffersController')->name('products.update.offers');

            //upload multiple image

            Route::get('product/upload/images', 'ShopProductMassUploadImageController@upload')->name('products.upload.image');

            Route::post('product/upload/images', 'ShopProductMassUploadImageController@store')->name('products.upload');

            Route::get('product/uploaded/images', 'ShopProductMassUploadImageController@view')->name('product.uploaded.images');

            Route::any('delete/uploaded/images{id}', 'ShopProductMassUploadImageController@delete')->name('ProductsImages.delete');



            Route::post(

                'product/images/delete/selected',

                'ShopProductMassUploadImageController@deleteSelected'

            )

                ->name('products.images.delete.selected');



            Route::post(

                'product/images/delete/filtered',

                'ShopProductMassUploadImageController@deleteFiltered'

            )

                ->name('products.images.delete.filtered');



            //upload multiple PDF

            Route::get('product/upload/PDFs', 'ShopProductMassUploadPdf@upload')->name('products.upload.PDF');

            Route::post('product/upload/PDFs', 'ShopProductMassUploadPdf@store')->name('products.PDFs.upload');

            Route::get('product/uploaded/PDFs', 'ShopProductMassUploadPdf@view')->name('product.uploaded.PDFs');

            Route::any('delete/uploaded/PDFs{id}', 'ShopProductMassUploadPdf@delete')->name('ProducstPDFs.delete');



            //banners

            Route::resource('banners', 'ShopBannerController');

            Route::get('banner/view', 'ShopBannerController@banners')->name('banners');



            Route::get('search-by-name', 'ShopProductController@searchByName')

                ->name('search-by-name');
        });

        //********* End Shop Products **************

        //*********Start Shop Offer Packages *************

        Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {

            Route::resource('offerPackages', 'OfferPackageController');

            Route::get('offers/packages/index', 'OfferPackageController@getOffers')->name('offers.packages');

            Route::post('offers/packages/delete/selected', 'OfferPackageController@deleteSelected')->name('offers.packages.delete.selected');

            Route::post('offers/packages/delete/all', 'OfferPackageController@deleteAll')->name('offers.packages.delete.all');
        });

        //********* End Shop Offer Packages **************

        //companies Controller

        Route::resource('companies', 'CompanyController');

        Route::get('company/view', 'CompanyController@companies')->name('company.companies');

        Route::get('company/join', 'CompanyController@joins')->name('company.join');



        Route::post('company/update/password', 'CompanyController@updatePassword')->name('company.update.password');

        Route::any('company/show/hide/{id}', 'CompanyController@ShowHideCompany')->name('company.show.hide');

        Route::any('company/gold/{id}', 'CompanyController@GoldCompany')->name('company.gold');

        Route::get('company/admin/login/{id}', 'CompanyController@login')->name('company.admin.login');

        Route::post('make/company/featured/{id}', 'CompanyController@makeFeatured')->name('companies.featured');

        Route::put('current/subscription/{id}', 'UpdateCurrentSubscriptionController')->name('current-subscription.update');

        Route::post('company/update/rank/point', 'CompanyController@RankPoint')->name('rank.point.company.update');

        //banners controller

        Route::resource('banners', 'BannerController');



        Route::get('banners/', 'BannerController@index')->name('banners.index');

        Route::get('banners/create/firstSection', 'BannerController@createFirstSection')->name('banners.home.create');

        Route::get('banners/create/secondSection', 'BannerController@createSecondSection')->name('banners.create.second');

        Route::get('banners/create/thirdSection', 'BannerController@createThirdSection')->name('banners.create.third');

        Route::post('banners/home/store', 'BannerController@storeHomeBanner')->name('banners.home.store');

        Route::post('banners/second/store', 'BannerController@storeSecondSection')->name('banners.second.store');

        Route::post('banners/third/store', 'BannerController@storeThirdSection')->name('banners.third.store');

        Route::put('banners/{id}/update', 'BannerController@update')->name('banners.update');

        Route::delete('banners/delete', 'BannerController@destroy')->name('banners.delete');





        Route::get('banner/view', 'BannerController@banners')->name('admin.banners');

        Route::get('banner/ads', 'BannerController@ads')->name('admin.banners.ads');

        Route::post('banner/ads/store', 'BannerController@adsStore')->name('ads.banner.store');

        Route::put('banner/ads/update/{id}', 'BannerController@adsUpdate')->name('ads.banner.update');



        //banners controller



        //Subscription Controller

        Route::resource('subscriptions', 'SubscriptionController')->except('show');

        Route::get('subscriptions/view', 'SubscriptionController@subscriptions')->name('subscriptions.subscriptions');



        // view companies with subscription

        Route::get('subscriptions/requests', 'SubscriptionController@requests')->name('subscriptions.requests');

        Route::get('subscriptions/renew', 'SubscriptionController@renew')->name('subscriptions.renew');

        Route::get('subscriptions/new', 'SubscriptionController@new')->name('subscriptions.new');

        Route::post('subscriptions/accept/{id}', 'SubscriptionController@accept')->name('subscriptions.accept');



        // view subscription requests

        Route::get('subscriptions/companies', 'SubscriptionController@companies')->name('subscriptions.companies');



        // view companies with expired subscription

        Route::get('subscriptions/expire', 'SubscriptionController@allexpired')->name('subscriptions.expire');

        // view companies with active subscription

        Route::get('subscriptions/active', 'SubscriptionController@allactive')->name('subscriptions.active');



        Route::get('subscribe/company', 'SubscriptionController@createAssignSubscription')->name('subscribe.company');

        Route::post('assign/subscription', 'AssignSubscriptionController')->name('assign-subscription');



        //ads controller

        Route::resource('advertisings', 'AdsController')->except(['show', 'destroy']);

        Route::get('ads/view', 'AdsController@advertisings')->name('advertising.advertisings');

        //ads controller

        //Settings and site map

        Route::get('settings/', 'SettingController@index')->name('site.settings');

        Route::post('settings/store', 'SettingController@store')->name('site.settings.store');

        Route::post('settings/update/{id}', 'SettingController@update')->name('site.settings.update');

        Route::get('site/map', 'SiteMapController@viewSiteMap')->name('site.map');

        Route::post('site/map/store', 'SiteMapController@storeSiteMap')->name('store.site.map');

        Route::delete('site/map/delete/{id}', 'SiteMapController@destroy')->name('delete.site.map');



        //Settings

        //cities

        Route::resource('cities', 'CityController')->except('show');

        Route::get('city/view', 'CityController@cities')->name('city.cities');



        Route::prefix('cities')->group(function () {

            Route::as('cities.')->group(function () {

                Route::get('delivery-charge', 'CityController@deliveryCharge')

                    ->name('delivery-charge');
            });
        });



        //cities

        // site brand and company Google Ads



        Route::get('settings/brands/adsImage', 'SettingController@showBrandImage')->name('brand.image');

        Route::post('settings/brands/adsImage', 'SettingController@addBrandImage')->name('brand.image');



        Route::get('settings/company/adsImage', 'SettingController@showCompanyImage')->name('company.image');

        Route::post('settings/company/adsImage', 'SettingController@addCompanyImage')->name('company.image');



        //search store

        Route::get('search/store/products', 'SearchController@Products')->name('search.store.product');

        Route::get('search/store/db/products', 'SearchController@getProducts')->name('search.store.products');

        Route::get('search/excel/products', 'SearchController@getExcelProducts')->name('products.search.file');



        Route::get('search/store/companies', 'SearchController@Companies')->name('search.store.company');

        Route::get('search/store/db/companies', 'SearchController@getCompanies')->name('search.store.companies');

        Route::get('search/excel/companies', 'SearchController@getExcelCompanies')->name('companies.search.file');



        Route::get('search/store/brands', 'SearchController@Brands')->name('search.store.brand');

        Route::get('search/store/db/brands', 'SearchController@getBrands')->name('search.store.brands');

        Route::get('search/excel/brands', 'SearchController@getExcelBrands')->name('brands.search.file');



        //Dashboard

        Route::get('website/visitors', 'DashboardController@site')->name('site.visitors');

        Route::get('website/show/db/visitors', 'DashboardController@getSiteVisitors')->name('get.site.visitors');



        Route::get('CompanyVisitors', 'DashboardController@companies')->name('company.visitors');

        Route::get('CompanyVisitors/show/db', 'DashboardController@getCompanyVisitors')->name('get.company.visitors');



        Route::get('brandVisitors/', 'DashboardController@brands')->name('brand.visitors');

        Route::get('brandVisitors/show/db', 'DashboardController@getBrandVisitors')->name('get.brand.visitors');

        //Dashboard

        //start terms & conditions

        Route::get('terms/', 'TermsController@index')->name('terms.view');

        Route::post('terms/save', 'TermsController@save')->name('terms.save');

        //end terms & conditions



        // refund

        Route::prefix('refund-and-returns-policy')->group(function () {

            Route::as('refund-and-returns-policy.')->group(function () {

                Route::get('/', 'RefundAndReturnsPolicyController@index')->name('view');

                Route::post('save', 'RefundAndReturnsPolicyController@save')->name('save');
            });
        });



        // end of refund



        //start sell policies

        Route::get('sell/policies/', 'SellPoliciesController@index')->name('sell.policies.view');

        Route::post('sell/policies/save', 'SellPoliciesController@save')->name('sell.policies.save');

        //end sell policies

        //start privacy and policiy

        Route::get('privacy/policies/', 'PrivacyPolicyController@index')->name('privacy.policy.view');

        Route::post('privacy/policies/save', 'PrivacyPolicyController@save')->name('privacy.policy.save');

        //end privacy and policiy



        Route::get('faqs/', 'FAQController@index')->name('faqs.view');

        Route::post('faqs/save', 'FAQController@save')->name('faqs.save');



        //logout as admin

        Route::any('logout', 'AdminAuthenticationController@logout')->name('admin.logout');



        Route::get('update/level2/categories', 'SiteMapController@updateLevel2');

        Route::get('update/level3/categories', 'SiteMapController@updateLevel3');

        Route::get('remove/category/levels', 'SiteMapController@removeLevel1and2');
    });



    /*

    -check manager middleware admin using admin guard

    -Manager priviliges

     */



    Route::group(['middleware' => 'manager:admin'], function () {

        //home

        Route::get('/', 'AdminAuthenticationController@home')->name('admin.home');

        //logout as admin

        Route::any('logout', 'AdminAuthenticationController@logout')->name('admin.logout');
    });



    /*

    -check cs middleware admin using admin guard

    -CS priviliges

     */

    Route::group(['middleware' => 'cs:admin'], function () {

        //home

        Route::get('/', 'AdminAuthenticationController@home')->name('admin.home');

        //logout as admin

        Route::any('logout', 'AdminAuthenticationController@logout')->name('admin.logout');
    });
});

Route::get('hideSelected', [ShopProductController::class, 'hideSelected'])->name('hideSelected');

Route::get('showSelected', [ShopProductController::class, 'showSelected'])->name('showSelected');
