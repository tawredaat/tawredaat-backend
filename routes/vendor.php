<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'vendors', 'namespace' => 'Vendor', 'as' => 'vendor.'], function () {

    // login
    Route::get('login', 'AuthController@login')->name('login');

    Route::post('login', 'AuthController@checkLogin')->name('login');

    // register
    Route::get('register', 'AuthController@viewRegister')->name('register');

    Route::post('register', 'AuthController@register')->name('register');

    Route::group(['middleware' => 'vendor:vendor'], function () {
        // dashboard
        Route::get('/', 'DashboardController@index')->name('index');

        // logout
        Route::get('logout', 'AuthController@logout')->name('logout');

        /**
         * shop products Module Routes
         */
        Route::resource('specifications', 'SpecificationController')->except(['show']);

        Route::prefix('specifications')->group(function () {
            Route:: as ('specifications.')->group(function () {
                Route::get('data', 'SpecificationController@data')->name('data');
            });
        });

        /**
         * Shop Products Module Routes
         */
        Route::resource('shop-products', 'ShopProductController')->except(['show']);

        Route::prefix('shop-products')->group(function () {
            Route:: as ('shop-products.')->group(function () {
                Route::get('data', 'ShopProductController@data')->name('data');

                Route::post('toggle-featured/{id}',
                    'ShopProductController@toggleFeatured')->name('toggle-featured');

                // specifications
                Route::get('products-specifications/{id}',
                    'ShopProductController@specifications')
                    ->name('specifications');

                Route::post('delete-selected',
                    'ShopProductController@deleteSelected')->name('delete-selected');

                Route::post('delete-all',
                    'ShopProductController@deleteAll')->name('delete-all');

                // update prices

                Route::get('update-prices', 'ShopProductController@updatePrices')
                    ->name('update-prices');

                Route::post('update-prices', 'ShopProductController@updatePricesExcel')
                    ->name('update-prices');

                Route::get('import', 'ShopProductController@import')
                    ->name('import');

                Route::post('import', 'ShopProductMassUpload')
                    ->name('import');

            });
        });

        Route::prefix('shop-product-images')->group(function () {
            Route:: as ('shop-product-images.')->group(function () {

                Route::get('images/{id}',
                    'ShopProductImageController@images')->name('images');

                Route::get('get-images/{id}', 'ShopProductImageController@getProductImages')
                    ->name('get-images');

                // products.uploadImages
                Route::post('upload/{id}',
                    'ShopProductImageController@upload')
                    ->name('upload');

                Route::delete('delete/{id}', 'ShopProductImageController@delete')
                    ->name('delete');

                Route::post('delete-selected', 'ShopProductImageController@deleteSelected')
                    ->name('delete-selected');

            });
        });

        Route::prefix('shop-products-offers')->group(function () {
            Route:: as ('shop-product-offers.')->group(function () {

                Route::get('index',
                    'ShopProductOfferController@index')->name('index');

                Route::get('data',
                    'ShopProductOfferController@data')->name('data');

                Route::post('remove-from-offers/{id}',
                    'ShopProductOfferController@removeFromOffer')->name('remove-from-offers');

                Route::post('delete-all',
                    'ShopProductOfferController@deleteAll')
                    ->name('delete-all');

            });
        });

        Route::prefix('shop-product-mass-pdfs')->group(function () {
            Route:: as ('shop-product-mass-pdfs.')->group(function () {
                //upload multiple PDF
                Route::get('upload', 'ShopProductMassUploadPDFController@upload')
                    ->name('upload');

                Route::post('upload', 'ShopProductMassUploadPDFController@store')
                    ->name('upload');

                Route::get('data', 'ShopProductMassUploadPDFController@data')
                    ->name('data');

                Route::delete('delete/{id}', 'ShopProductMassUploadPDFController@delete')
                    ->name('delete');
            });
        });

        Route::prefix('shop-product-mass-images')->group(function () {
            Route:: as ('shop-product-mass-images.')->group(function () {
                Route::get('upload', 'ShopProductMassUploadImageController@upload')
                    ->name('upload');

                Route::post('upload', 'ShopProductMassUploadImageController@store')
                    ->name('upload');

                Route::get('data', 'ShopProductMassUploadImageController@data')
                    ->name('data');

                Route::delete('delete/{id}', 'ShopProductMassUploadImageController@delete')
                    ->name('delete');
            });
        });

        // vendors

        Route::prefix('vendors')->group(function () {
            Route:: as ('vendors.')->group(function () {
                Route::get('edit', 'VendorController@edit')
                    ->name('edit');

                Route::post('update/{id}', 'VendorController@update')
                    ->name('update');
            });
        });

    });
});
