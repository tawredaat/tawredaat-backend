<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Resources\SettingResource;
use App\Http\Resources\SocialLinksFromSettingsResource;
use App\Models\Setting;
use App\Repository\User\HomeRepo;
use Illuminate\Http\Request;

class HomeController extends BaseResponse
{

    protected $homeRepo;

    public function __construct(HomeRepo $homeRepo)
    {
        $this->homeRepo = $homeRepo;
    }

    public function index(Request $request)
    {
        // used 
        // $result['featuredShopCategories'] = $this->homeRepo->featuredShopCategories()['object']['featuredShopCategories'];
       
       //return shown categories 
        $result['shownCategories'] =
        $this->homeRepo->shownCategories()['object']['shownCategories'];
        // return level 1 categories and all the featured products under them
        $result['categoriesProducts'] =
        $this->homeRepo->categoriesProducts($request)['object']['categoriesProducts'];
        $result['sliderBanners'] = $this->homeRepo->banners()['object']['banners'];
        $result['recentlyProducts'] = $this->homeRepo->arrivedRecently()['object']['recently_arrived'];
        $result['bestSellerProducts'] =
        $this->homeRepo->bestSellerProducts($request)['object']['bestSellerProducts'];
        $result['featuredShopProducts'] =
        $this->homeRepo->featuredShopProducts()['object']['featuredShopProducts'];
        $result['banners'] = $this->homeRepo->adBanners()['object']['ad_banners'];
        $setting = Setting::first();
        $result['rfqImage'] = $setting && $setting->rfq_image ? asset('storage' . DIRECTORY_SEPARATOR . $setting->rfq_image) : null;
        $result['recentlyViewed'] = $this->homeRepo->recentlyViewed()['object']['recentlyViewed'];
        $result['socialLinks'] = new SocialLinksFromSettingsResource($setting);

        return $this->response(200, "Home Screen", 200, [], 0, $result);
    }

    public function termsConditions()
    {
        $result = $this->homeRepo->termsConditions();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }
    public function PrivacyPolicy()
    {
        $result = $this->homeRepo->PrivacyPolicy();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function sellPolicies()
    {
        $result = $this->homeRepo->sellPolicies();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }
    public function settings()
    {
        $setting = Setting::first();
        if (!$setting) {
            return $this->response(101, "Validation Error", 200, 'The web site has no settings yet');
        }

        $result['setting'] = new SettingResource($setting);
        return $this->response(200, "Website Settings", 200, [], 0, $result);
    }

    public function adBanners()
    {
        $result = $this->homeRepo->adBanners();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function banners()
    {
        $result = $this->homeRepo->banners();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function featuredCategories()
    {
        $result = $this->homeRepo->featuredCategories();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function featuredCompanies()
    {
        $result = $this->homeRepo->featuredCompanies();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function featuredBrands()
    {
        $result = $this->homeRepo->featuredBrands();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function countries()
    {
        $result = $this->homeRepo->listAllCountries();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }
    
    public function homeBanners()
    {

        $result= $this->homeRepo->banners()['object']['banners'];
        return $this->response(200, "Home Screen", 200, [], 0, $result);
    }
    
    public function searchByProduct()
    {
        $result = $this->homeRepo->filterAllProducts();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
  
    public function searchByProductCount()
    {
        $result = $this->homeRepo->countFilterAllProducts();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function filterProductsByBrand()
    {
        $result = $this->homeRepo->filterProductsByBrand();
    
        if (isset($result['success'])) { // Check if 'success' key exists
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif (isset($result['errors'])) { // Check if 'errors' key exists
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
  
    public function homeSeo(){
        $result = $this->homeRepo->homeSeo();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0 ,$result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
}
