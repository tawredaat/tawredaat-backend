<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\ShopProduct;
use App\Models\Vendor;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//Check if user is looged in or not
if (!function_exists('isLogged')) {
    function isLogged()
    {
        $isLogged = 0;
        if (Auth::guard('web')->check()) {
            $isLogged = 1;
        }

        return $isLogged;
    }
}
/**
 * Get id of current user loged in.
 *
 * @return string
 */
if (!function_exists('UserID')) {
    function UserID()
    {
        return auth('web')->user() ? auth('web')->user()->id : null;
    }
}
/**
 * Get id of current admin loged in.
 *
 * @return string
 */
if (!function_exists('AdminID')) {
    function AdminID()
    {
        return auth('admin')->user()->id;
    }
}
/**
 * Get id of current company loged in.
 *
 * @return string
 */
if (!function_exists('CompanyID')) {
    function CompanyID()
    {
        return auth('company')->user()->id;
    }
}
/**
 * Get id of current company loged in.
 *
 * @return string
 */
if (!function_exists('CompanyName')) {
    function CompanyName()
    {
        return auth('company')->user()->name;
    }
}
/**
 * Get name of current admin loged in.
 *
 * @return string
 */
if (!function_exists('AdminName')) {
    function AdminName()
    {
        return auth('admin')->user()->name;
    }
}
/**
 * Get encrypted pass of current admin loged in.
 *
 * @return string
 */
if (!function_exists('AdminPass')) {
    function AdminPass()
    {
        return auth('admin')->user()->password;
    }
}
/**
 * Get email of current admin loged in.
 *
 * @return string
 */
if (!function_exists('AdminEmail')) {
    function AdminEmail()
    {
        return auth('admin')->user()->email;
    }
}

/**
 * Get privilege of current admin loged in.
 *
 * @return string
 */
if (!function_exists('AdminPrivileges')) {
    function AdminPrivileges()
    {
        return auth('admin')->user()->privilege;
    }
}
/**
 * Check if admin is loged in or not.
 *
 * @return boolean
 */
if (!function_exists('AdminLogged')) {
    function AdminLogged()
    {
        return auth('admin')->check();
    }
}
/**
 * validate images.
 *
 * @return string
 */
if (!function_exists('ValidateImage')) {
    function ValidateImage($ext = null)
    {
        if ($ext === null) {
            return 'image|mimes:jpg,jpeg,png,gif,bmp,webp';
        } else {
            return 'image|mimes:' . $ext;
        }

    }
}
/**
 * Used To generate random code.
 *
 * @return string
 */
if (!function_exists('generateRandomCode')) {
    function generateRandomCode($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

/**
 ****************************Admin Dashboard functions****************************
 * Count Of all users in registered at website.
 *
 * @return number
 */
if (!function_exists('CountUsers')) {
    function CountUsers()
    {
        return App\User::count();
    }
}
/***** Count Of companies requests.
 *
 * @return number
 */
if (!function_exists('SiteVisitors')) {
    function CompanyRequests()
    {
        return App\Models\CompanyRequest::count();
    }
}
/***** Count Of all users in registered at website.
 *
 * @return number
 */
if (!function_exists('SiteVisitors')) {
    function SiteVisitors()
    {
        return App\Models\SiteVisitor::count();
    }
}
/***** Count Of all users in registered at website.
 *
 * @return number
 */
if (!function_exists('CompanyVisitors')) {
    function CompanyVisitors()
    {
        return App\Models\CompanyVisitor::count();
    }
}
/***** Count Of all users in registered at website.
 *
 * @return number
 */
if (!function_exists('BrandVisitors')) {
    function BrandVisitors()
    {
        return App\Models\BrandVisitor::count();
    }
}

//  averageOrdersValue()
/***** Average order value.
 *
 * @return number
 */
if (!function_exists('averageOrdersValue')) {
    function averageOrdersValue()
    {
        if (Order::count('id') == 0) {
            return 0;
        }

        return round(Order::sum('total') /
            Order::count('id'), 3);
    }
}

/*****
 *
 * @return string
 */
if (!function_exists('topProduct')) {
    function topProduct()
    {
        $order_items = OrderItem::selectRAW('id, shop_product_id, count(shop_product_id) as value_occurrence')
            ->groupBy('shop_product_id')
            ->orderBy('value_occurrence', 'DESC')->get();

        if (count($order_items) == 0) {
            return "";
        }

        $product = ShopProduct::where('id', $order_items[0]->shop_product_id)
            ->select('id')->with('translations')->first();

        $product_name = "";
        if (!is_null($product)) {
            $product_name = $product->name;
        }

        if (OrderItem::count('id') == 0) {
            $percentage = 0;
        } else {
            $percentage = ($order_items[0]['value_occurrence'] / OrderItem::count('id'))
                 * 100;
        }

        return $product_name . " " . round($percentage, 2) . "% of all orders";
    }
}

/***** Average order delivery time.
 *
 * @return string
 */
if (!function_exists('averageOrderDeliveryTime')) {
    function averageOrderDeliveryTime()
    {
        $order_status_delivered_histories = OrderStatusHistory::select('id', 'order_id', 'status_id', 'created_at')
            ->where('status_id', config('global.delivered_order_status', 4))
            ->get();

        $days_between_pending_delivered = 0;

        foreach ($order_status_delivered_histories as $order_status_history) {
            $order_with_pending_status =
            OrderStatusHistory::select('id', 'order_id', 'status_id', 'created_at')
                ->where('order_id', $order_status_history->order_id)
                ->where('status_id', config('global.pending_order_status', 1))
                ->first();
            //
            if (!is_null($order_with_pending_status)) {
                $from = Carbon::parse($order_with_pending_status->created_at);
                $to = Carbon::parse($order_status_history->created_at);

                $days_between_pending_delivered += $to->diffInDays($from);
            }
        }

        if (count($order_status_delivered_histories) != 0) {
            return round($days_between_pending_delivered /
                count($order_status_delivered_histories), 2);
        }

        return 0;
    }
}

/***** Top Brand
 *
 * @return string
 */
if (!function_exists('topBrand')) {
    function topBrand()
    {
        // Corrected query
        $query = DB::select('SELECT shop_products.brand_id, COUNT(shop_products.brand_id) as brand_value_occurrence
            FROM order_items 
            INNER JOIN shop_products ON shop_products.id = order_items.shop_product_id
            GROUP BY shop_products.brand_id
            ORDER BY brand_value_occurrence DESC');

        if (empty($query)) {
            return " ";
        }

        // Fetch the brand name
        $brand = Brand::where('id', $query[0]->brand_id)->with('translations')->first();
        $brand_name = $brand ? $brand->name : 'Unknown';

        // Calculate percentage
        $total_orders = OrderItem::whereNotNull('shop_product_id')->count();
        $percentage = $total_orders > 0 ? ($query[0]->brand_value_occurrence / $total_orders) * 100 : 0;

        return $brand_name . " " . round($percentage, 2) . "% of all orders";
    }
}

/***** Top Category
 *
 * @return string
 */
if (!function_exists('topCategory')) {
    function topCategory()
    {
        // Corrected query
        $query = DB::select('SELECT shop_products.category_id, COUNT(shop_products.category_id) as category_value_occurrence
            FROM order_items 
            INNER JOIN shop_products ON shop_products.id = order_items.shop_product_id
            GROUP BY shop_products.category_id
            ORDER BY category_value_occurrence DESC');

        if (empty($query)) {
            return " ";
        }

        // Fetch the category name safely
        $category = Category::where('id', $query[0]->category_id)->with('translations')->first();
        $category_name = $category ? $category->name : 'Unknown';

        // Calculate percentage safely
        $total_orders = OrderItem::whereNotNull('shop_product_id')->count();
        $percentage = $total_orders > 0 ? ($query[0]->category_value_occurrence / $total_orders) * 100 : 0;

        return $category_name . " " . round($percentage, 2) . "% of all orders";
    }
}

/***** Top Category
 *
 * @return string
 */
if (!function_exists('topCity')) {
    function topCity()
    {
        // Corrected query
        $query = DB::select('SELECT user_addresses.city_id, COUNT(user_addresses.city_id) as city_value_occurrence
            FROM orders 
            INNER JOIN user_addresses ON user_addresses.id = orders.user_address_id
            GROUP BY user_addresses.city_id
            ORDER BY city_value_occurrence DESC');

        if (empty($query)) {
            return " ";
        }

        // Fetch the city name safely
        $city = City::where('id', $query[0]->city_id)->with('translations')->first();
        $city_name = $city ? $city->name : 'Unknown';

        // Calculate percentage safely
        $total_orders = Order::count();
        $percentage = $total_orders > 0 ? ($query[0]->city_value_occurrence / $total_orders) * 100 : 0;

        return $city_name . " " . round($percentage, 2) . "% of all orders";
    }
}

/**
 * Count Of all products added in admin portal.
 *
 * @return number
 */
if (!function_exists('CountProducts')) {
    function CountProducts()
    {
        return App\Models\Product::count();
    }
}
/**
 * Count Of all subscriptions added in admin portal.
 *
 * @return number
 */
if (!function_exists('CountSubscriptions')) {
    function CountSubscriptions()
    {
        return App\Models\Subscription::count();
    }
}
/**
 * Count Of all Companies added in admin portal.
 *
 * @return number
 */
if (!function_exists('CountCompanies')) {
    function CountCompanies()
    {
        return App\Models\Company::count();
    }
}

/**
 * Count Of all vendors added in admin portal.
 *
 * @return number
 */
if (!function_exists('countVendors')) {
    function countVendors()
    {
        return Vendor::count('id');
    }
}

/**
 * Count Of all units in registered at website.
 *
 * @return number
 */
if (!function_exists('CountUnits')) {
    function CountUnits()
    {
        return App\Models\Unit::count();
    }
}
/**
 * Count Of all Area added in admin portal.
 *
 * @return number
 */
if (!function_exists('CountAreas')) {
    function CountAreas()
    {
        return App\Models\Area::count();
    }
}
/**
 * Count Of all Countries added in admin portal.
 *
 * @return number
 */
if (!function_exists('CountCountries')) {
    function CountCountries()
    {
        return App\Models\Country::count();
    }
}
/**
 * Count Of all Categories registered at website.
 *
 * @return number
 */
if (!function_exists('CountCategories')) {
    function CountCategories()
    {
        return App\Models\Category::count();
    }
}

/**
 * Count Of all Promocodes added in admin portal.
 *
 * @return number
 */
if (!function_exists('CountPromocodes')) {
    function CountPromocodes()
    {
        return App\Models\Promocode::count();
    }
}
/**
 * Count Of all Ads added in admin portal.
 *
 * @return number
 */
if (!function_exists('CountAds')) {
    function CountAds()
    {
        return App\Models\Advertising::count();
    }
}
/**
 * Count Of all Brands registered at website.
 *
 * @return number
 */
if (!function_exists('CountBrands')) {
    function CountBrands()
    {
        return App\Models\Brand::count();
    }
}

/**
 ****************************Company Dashboard functions****************************
 * Count Of all products assigned to a company.
 *
 * @return number
 */
if (!function_exists('CompanyProducts')) {
    function CompanyProducts()
    {
        return App\Models\CompanyProduct::where('company_id', CompanyID())->whereNotNull('product_id')->count();
    }
}
/**
 * Count Of all brands assigned to a company.
 *
 * @return number
 */
if (!function_exists('CompanyBrands')) {
    function CompanyBrands()
    {
        $brands_ids = App\Models\CompanyProduct::where('company_id', CompanyID())->pluck('brand_id');
        return App\Models\Brand::whereIn('id', $brands_ids)->count();
    }
}
/**
 * Count Of all categories assigned to a company.
 *
 * @return number
 */
if (!function_exists('CompanyCategories')) {
    function CompanyCategories()
    {
        $products_ids = App\Models\CompanyProduct::where('company_id', CompanyID())->pluck('product_id');
        $products = App\Models\Product::whereIn('id', $products_ids)->pluck('category_id');
        return App\Models\Category::where('level', 'level3')->whereIn('id', $products)->pluck('id')->count();
    }
}
/**
 * Count Of all call back requests with  a company.
 *
 * @return number
 */
if (!function_exists('CompanyCallBackRequests')) {
    function CompanyCallBackRequests()
    {
        return App\Models\CallbackRequest::where('company_id', CompanyID())->count();
    }
}

/**
 * Count Of all whatsup call   with  a company.
 *
 * @return number
 */
if (!function_exists('CompanyWhatsuCallRequests')) {
    function CompanyWhatsuCallRequests()
    {
        return App\Models\WhatsappCall::where('company_id', CompanyID())->count();
    }
}
/**
 * Count Of all General Rfqs with  a company.
 *
 * @return number
 */
if (!function_exists('CompanyGeneralRfqs')) {
    function CompanyGeneralRfqs()
    {
        return App\Models\GeneralRfq::where('company_id', CompanyID())->count();
    }
}

/**
 * Count Of all User Rfqs with  a company.
 *
 * @return number
 */
if (!function_exists('userRfqs')) {
    function userRfqs()
    {
        return App\Models\Rfq::count('id');
    }
}

/**
 * Count Of all General Rfqs with  a company.
 *
 * @return number
 */
if (!function_exists('CompanyMoreInfoBtns')) {
    function CompanyMoreInfoBtns()
    {
        return App\Models\MoreInfo::where('company_id', CompanyID())->count();
    }
}
/**
 * Count Of all Products Rfqs with  a company.
 *
 * @return number
 */
if (!function_exists('CompanyProductRfqs')) {
    function CompanyProductRfqs()
    {
        return App\Models\ProductRfq::where('company_id', CompanyID())->count();
    }
}
/**
 * Count Of all Profile Views with  a company.
 *
 * @return number
 */
if (!function_exists('CompanyProfileViews')) {
    function CompanyProfileViews()
    {
        return App\Models\ViewInformation::where('company_id', CompanyID())->count();
    }
}
/**
 * Count Of all Pdf Downloads with  a company.
 *
 * @return number
 */
if (!function_exists('CompanyPdfDownloads')) {
    function CompanyPdfDownloads()
    {
        return App\Models\PdfDownload::where('company_id', CompanyID())->count();
    }
}

/**
 * return name of company subscription.
 *
 * @return string
 */
if (!function_exists('CompanySecscription')) {
    function CompanySecscription()
    {
        $company_subscrip = App\Models\CompanySubscription::with('subscription')->where('company_id', CompanyID())->first();
        if ($company_subscrip) {
            return $company_subscrip->subscription->name;
        }
        return null;
    }
}

/**
 * return days of remaining subscription.
 *
 * @return number
 */
if (!function_exists('CompanyDayToEndSecscription')) {
    function CompanyDayToEndSecscription()
    {
        $company_subscrip = App\Models\CompanySubscription::with('subscription')->where('company_id', CompanyID())->first();
        //calculte number of days between current date and end date of subscription
        if (isset($company_subscrip->end_date)) {
            $end_date = new DateTime(\Carbon\Carbon::parse($company_subscrip->end_date)->format('m/d/Y'));
            $current_date = new DateTime(date("m/d/Y"));
            $interval = $end_date->diff($current_date);
            $days = $interval->format('%a');
        } else {
            $days = null;
        }

        return $days;
    }
}

if (!function_exists('paginateArray')) {
    /**
     * Paginate given array with appending parameters and number of objects per page
     * @param $data
     * @param array $params
     * @param int $perPage
     * @return LengthAwarePaginator
     */

    function paginateArray($data, $params = array(), $perPage = 12)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($data);

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);

        // set url path for generated links
        $paginatedItems->setPath(url()->current())->appends($params);

        return $paginatedItems;
    }
}

/**
 * return count of subscrption request
 *
 * @return number
 */
if (!function_exists('SecscriptionRequest')) {
    function SecscriptionRequest()
    {
        return App\Models\CompanySubscription::with(['company', 'subscription'])->where('pending', 2)->count();
    }
}

/**
 * return count of subscrption active
 *
 * @return number
 */
if (!function_exists('SubscriptionActive')) {
    function SubscriptionActive()
    {
        return App\Models\CompanySubscription::with(['company', 'subscription'])->where('end_date', '>=', now()->format('Y-m-d H:i:s'))->count();
    }
}
/**
 * return count of subscrption expired
 *
 * @return number
 */
if (!function_exists('SubscriptionExpired')) {
    function SubscriptionExpired()
    {
        return App\Models\CompanySubscription::with(['company', 'subscription'])->where('end_date', '<', now()->format('Y-m-d H:i:s'))->count();
    }
}

/**
 * return count of search in  products
 *
 * @return number
 */
if (!function_exists('ProductsSearch')) {
    function ProductsSearch()
    {
        return App\Models\SearchStore::where('search_type', 'product')->count();
    }
}
/**
 * return count of search in  companies
 *
 * @return number
 */
if (!function_exists('CompaniesSearch')) {
    function CompaniesSearch()
    {
        return App\Models\SearchStore::where('search_type', 'company')->count();
    }
}
/**
 * return count of search in  brands
 *
 * @return number
 */
if (!function_exists('BrandsSearch')) {
    function BrandsSearch()
    {
        return App\Models\SearchStore::where('search_type', 'brand')->count();
    }
}

/**
 * return count of Products
 *
 * @return number
 */
if (!function_exists('AllShopProducts')) {
    function AllShopProducts()
    {
        return App\Models\ShopProduct::count();
    }
}

/**
 * return count of Products
 *
 * @return number
 */
if (!function_exists('AllShopProductsWithQuantity')) {
    function AllShopProductsWithQuantity()
    {
        return App\Models\ShopProduct::where('qty' , '>' , 0)->count();
    }
}

/**
 * return count of Products
 *
 * @return number
 */
if (!function_exists('AllShopProductsWithoutQuantity')) {
    function AllShopProductsWithoutQuantity()
    {
        return App\Models\ShopProduct::where('qty' , '<=' , 0)->count();
    }
}

/**
 * return count of level One Category
 *
 * @return number
 */
if (!function_exists('CategoryLevelOne')) {
    function CategoryLevelOne()
    {
        return App\Models\Category::where('show' , 1)->where('level' , 'level1')->count();
    }
}

/**
 * return Company Ads
 *
 * @return number
 */
if (!function_exists('CompanyHorizontalAd')) {
    function CompanyHorizontalAd()
    {
        return App\Models\Advertising::where('type', 'company')->where('alignment', 'horizontal')->first();
    }
}

if (!function_exists('CompanyVerticalAd')) {
    function CompanyVerticalAd()
    {
        return App\Models\Advertising::where('type', 'company')->where('alignment', 'vertical')->first();
    }
}
/**
 * return Brand Ads
 *
 * @return number
 */
if (!function_exists('BrandHorizontalAd')) {
    function BrandHorizontalAd()
    {
        return App\Models\Advertising::where('type', 'brand')->where('alignment', 'horizontal')->first();
    }
}

if (!function_exists('BrandVerticalAd')) {
    function BrandVerticalAd()
    {
        return App\Models\Advertising::where('type', 'brand')->where('alignment', 'vertical')->first();
    }
}
/**
 * return Category Ads
 *
 * @return number
 */
if (!function_exists('CategoryHorizontalAd')) {
    function CategoryHorizontalAd($categoryID)
    {
        return App\Models\Advertising::where('category_id', $categoryID)->where('type', 'category')->where('alignment', 'horizontal')->first();
    }
}

if (!function_exists('CategoryVerticalAd')) {
    function CategoryVerticalAd($categoryID)
    {
        return App\Models\Advertising::where('category_id', $categoryID)->where('type', 'category')->where('alignment', 'vertical')->first();
    }
}

/**
 * return product Ads
 *
 * @return number
 */
if (!function_exists('ProductHorizontalAd')) {
    function ProductHorizontalAd()
    {
        return App\Models\Advertising::where('type', 'product')->where('alignment', 'horizontal')->first();
    }
}

if (!function_exists('ProductVerticalAd')) {
    function ProductVerticalAd()
    {
        return App\Models\Advertising::where('type', 'product')->where('alignment', 'vertical')->first();
    }

}

function slugInArabic($string, $separator = '-')
{
    if (is_null($string)) {
        return "";
    }
    $string = trim($string);
    $string = mb_strtolower($string, "UTF-8");
    $string = str_replace('/', $separator, $string);
    $string = str_replace('\\', $separator, $string);
    $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $string = preg_replace("/[\s_]/", $separator, $string);
    return $string;
}



if (!function_exists('sendMail')) {
    function sendMail($toEmail,$toName,$subject,$logo,$app_name,$view,$order=null)
    {
        $variables =  [
            'subject' => $subject,
            'user_first_name' => $toName,
            'app_name' =>   $app_name,
            'logo' => asset('storage/' . $logo),
            'order' => $order
        ];
        // Render the Laravel Blade template with variables
        $content = view($view, $variables)->render();

        $client = new Client([
            'auth' => [
                'cdb9abf3ea77eabfd41a89ea6a16d4e5',
                '0709f2661d8c36a3660aa0fb65d45a63',
            ],
        ]);

        $response = $client->post('https://api.mailjet.com/v3.1/send', [
            'json' => [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => 'mragab@tawredaat.com',
                            'Name' => 'Tawredaat',
                        ],
                        'To' => [
                            [
                                'Email' => $toEmail,
                                'Name' => $toName,
                            ],
                        ],
                        'Subject' => $subject,
                        'HTMLPart' => $content,
                    ],
                ],
            ],
        ]);

    }
}
