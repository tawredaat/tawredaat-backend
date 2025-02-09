<?php
	Route::group(['prefix'=>'companies','namespace'=>'Company','as'=>'company.'],function()
	{
		Route::get('login','CompanyAuthenticationController@login')->name('login');
		Route::post('login','CompanyAuthenticationController@checkLogin')->name('login');
		//Change default guard ('web') to company guard
		Config::set('auth.defines','company');

		Route::group(['middleware'=>'company:company'],function(){
			//home
			Route::get('/','CompanyAuthenticationController@home')->name('home');
			//dashboard
				//categories
			Route::get('/categories/view','DashboardController@category')->name('view.categories');
			//dashboard
			//team members
			Route::resource('members','TeamMemberController');
			Route::get('team/members/view','TeamMemberController@members')->name('members');
			//team members
			//brands
			Route::get('/brands/view','BrandController@index')->name('view.brands');
			Route::get('/brands/assign/','BrandController@assign')->name('assign.brand');
			Route::post('/brnds/update','BrandController@update')->name('update.type.brands');
			Route::any('unassign/brand/products/{id}','BrandController@unassign')->name('unassign.brand');
			//brands
			// reports
				//profile view
			Route::get('viewInformation', 'ReportController@viewInformation')->name('viewInformation');
				//more info button
			Route::get('more/info/btn', 'ReportController@moreInfo')->name('moreInfo');
			Route::get('callbacks', 'ReportController@callbacks')->name('callbacks');
            Route::get('whatsup-callbacks', 'ReportController@whatsCallbacks')->name('whatscallbacks');
			Route::get('pdfs', 'ReportController@pdfs')->name('pdfs');
			Route::get('products/rfq', 'ReportController@generalRfqs')->name('products.rfq');
            Route::get('products/rfq/{id}/details', 'ReportController@generalRfqDetails')->name('products.rfq.details');
            Route::get('product/rfqs', 'ReportController@productRfqs')->name('product.rfq');
            Route::get('product/rfqs/{id}/details', 'ReportController@productRfqDetails')->name('product.rfq.details');

            // subscriptiosn
			Route::get('subscription', 'CompanyController@subscription')->name('subscription');
			Route::post('subscription/renew', 'CompanyController@renewSubscription')->name('subscription.renew');
			Route::post('subscription/new/{id}', 'CompanyController@newSubscription')->name('subscription.new');

			//branches
			Route::resource('branches','BranchController');
			Route::get('branche/view','BranchController@branches')->name('branches');
			//branches


            // rfqs
            Route::get('rfqs/view','RfqController@index')->name('rfqs');
            Route::get('get-rfqs','RfqController@rfqs')->name('get.rfqs');
            Route::get('rfq-details/{id}','RfqController@rfqDetails')->name('rfq.details');
            Route::post('rfq-response/{id}','RfqController@response')->name('rfq.response');
            Route::get('responded-rfqs/view','RfqController@respondedIndex')->name('responded.rfqs');
            Route::get('responded-rfqs','RfqController@respondedRfqs')->name('get.responded.rfqs');

            //product rfq
            Route::get('product-rfqs/view','ProductRfqController@index')->name('product-rfqs');
            Route::get('get-product-rfqs','ProductRfqController@rfqs')->name('get.product.rfqs');
            Route::post('respond-product-rfqs/{id}','ProductRfqController@respondrfqs')->name('product.respondrfqs');


            //areas operations
			Route::resource('areasOperations','AreaOperationController');
			Route::get('areas/operations/view','AreaOperationController@areas')->name('area.operations');
			//areas operations
			//certificate
			Route::resource('certificate','CertificateController');
			Route::get('certificates/view','CertificateController@certificates')->name('certificates');

			//certificate
			//Types
			Route::resource('types','TypeController');
			Route::get('company-types','TypeController@company_types')->name('company_types');
			//Types
			//admins
			Route::resource('admins','AdminController');
			Route::get('admin/view','AdminController@admins')->name('admin.admins');
			//admins
			//company settings
			Route::resource('companies','CompanyController');
			//company settings
			Route::any('logout','CompanyAuthenticationController@logout')->name('logout');
			//assign products tp company
			Route::resource('products','ProductsController');
			Route::get('selectBrands','ProductsController@selectBrands')->name('products.selectBrands');
			Route::get('selectedBrands','ProductsController@selectedBrands')->name('selectedBrands');

			Route::get('selectedL1Categories','ProductsController@selectedL1Categories')->name('selectedL1Categories');
			Route::get('selectedL2Categories','ProductsController@selectedL2Categories')->name('selectedL2Categories');
			Route::get('selectedL3Categories','ProductsController@selectedL3Categories')->name('selectedL3Categories');
			Route::post('selectedProducts','ProductsController@selectedProducts')->name('selectedProducts');
			Route::get('view/products','ProductsController@new_index')->name('products.view');
			Route::get('products/new/index', 'ProductsController@getProducts')->name('products.new.index');

			Route::get('Assigned/products/view','ProductsController@Assignedproducts')->name('Assignedproducts');

			//get level one categories based on brand selected
			Route::post('categories/levels1','ProductsController@levelOneOfSelectedBrand')->name('brand.categories.levels1');

			//get level two categories based on level on based on brand
			Route::post('categories/levels2','ProductsController@levelTwoOfSelectedLevel1')->name('level1.categories.levels2');

			Route::post('categories/levels3','ProductsController@levelThreeOfSelectedLevel2')->name('level2.categories.levels3');
			Route::post('categories/products','ProductsController@products')->name('categories.products');
			//assign products tp company
		});
	});
