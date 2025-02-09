<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Mail\OrderCanceledMail;
use App\Mail\OrderPlacedMail;
use App\Mail\OrderShippedMail;
use App\Mail\SubscriptionEndDaytMail;
use App\Models\Company;
use App\Models\CompanySubscription;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\Company\CompanyRequestRequest;
Use App\Models\SiteVisitor;
Use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Repository\User\HomeRepo;

class HomeController extends Controller
{

    protected $homeRepo;

    public function __construct(HomeRepo $homeRepo)
    {
        $this->homeRepo = $homeRepo;
    }

    /**
     * Show Home page
     *
     * @return view
     */
	public function home()
	{
        $result = $this->homeRepo->home();
        if($result['success']){
            // if (Cache::has('adBanner'))
            //     $adBanner =  Cache::get('adBanner');
            // else {
            //     Cache::put('adBanner', $result['object']['ads_banners'],now()->addMinutes(1440));
            //     $adBanner =  Cache::get('adBanner');
            // }
            $adBanner = $result['object']['ads_banners'];
            // if (Cache::has('SiteBanners'))
            //     $SiteBanners =  Cache::get('SiteBanners');
            // else {
            //     Cache::put('SiteBanners', $result['object']['banners'],now()->addMinutes(1440));
            //     $SiteBanners =  Cache::get('SiteBanners');
            // }
            $SiteBanners = $result['object']['banners'];
            // if (Cache::has('gridCategories'))
            //     $gridCategories =  Cache::get('gridCategories');
            // else {
            //     Cache::put('gridCategories', $result['object']['gridCategories']);
            //     $gridCategories =  Cache::get('gridCategories');
            // }
            $gridCategories = $result['object']['gridCategories'];


            // if (Cache::has('TrendingCompanies'))
            //     $TrendingCompanies =  Cache::get('TrendingCompanies');
            // else {
            //     Cache::put('TrendingCompanies', $result['object']['TrendingCompanies'],now()->addMinutes(1440));
            //     $TrendingCompanies =  Cache::get('TrendingCompanies');
            // }
            $TrendingCompanies = $result['object']['TrendingCompanies'];
            // if (Cache::has('TrendingBrands'))
            //     $TrendingBrands =  Cache::get('TrendingBrands');
            // else {
            //     Cache::put('TrendingBrands', $result['object']['TrendingBrands'],now()->addMinutes(1440));
            //     $TrendingBrands =  Cache::get('TrendingBrands');
            // }
            $TrendingBrands = $result['object']['TrendingBrands'];

            $productCount =$result['object']['productCount']; ;
            $companiesCount = $result['object']['companyCount']; ;
            $bandCount = $result['object']['brandCount'];;
            $categories = $result['object']['categoryCount'];;
            //store website visitors
            if (!session()->has('device')) {
                session()->put('device', Str::random(10));
                SiteVisitor::create(['user_id'=>UserID(),'device'=>session()->get('device')]);
            }elseif(session()->has('device') AND isLogged())
                SiteVisitor::where('device',session()->get('device'))->update(['user_id'=>UserID()]);
            $lang_changed = $this->langChanged();
            return view('User.home',compact('productCount','companiesCount','bandCount','categories','adBanner','lang_changed','SiteBanners','gridCategories','TrendingCompanies','TrendingBrands'));
        }
        else
            abort(500);
	}
    /**
     * Show all Blogs page
     * @return view
     */
    public function showblogs(){
        $result = $this->homeRepo->blogs();
        if($result['success']){
            $lang_changed = $this->langChanged();
            $blogs = $result['object']['blogs'];
            return view('User.blogs',compact('blogs','lang_changed'));
        }else
            abort(500);
    }
    /**
     * Show single blog  data
     * @param $blogtitle, $id
     * @return view
     */
    public function showsingleblog($blogtitle,$id)
    {
        $result  = $this->homeRepo->blog($id);
        if($result['success']){
            $lang_changed = $this->langChanged();
            $blog = $result['object']['blog'];
            return view('User.single_blog',compact('blog','lang_changed'));
        }
        elseif ($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * Show Terms & Conditions page
     * @return view
     */
    public function termsConditions(){
        $result = $this->homeRepo->termsConditions();
        if($result['success']){
            if (Cache::has('terms'))
                $terms =  Cache::get('terms');
            else {
                Cache::put('terms', $result['object']['terms'],now()->addMinutes(1440));
                $terms =  Cache::get('terms');
            }
            $lang_changed = $this->langChanged();
            return view('User.terms_conditions',compact('terms','lang_changed'));
        }else
            abort(500);
    }
    /**
     * Show Sell Policies page
     * @return view
     */
    public function sellPolicies(){
        $result = $this->homeRepo->sellPolicies();
        if($result['success']){
            if (Cache::has('sell'))
                $sell =  Cache::get('sell');
            else {
                Cache::put('sell', $result['object']['policy'],now()->addMinutes(1440));
                $sell =  Cache::get('sell');
            }
            $lang_changed = $this->langChanged();
            return view('User.sell_policies',compact('sell','lang_changed'));
        }
        else
            abort(500);

    }
    /**
     * Show Privacy & Policy page
     * @return view
     */
    public function PrivacyPolicy(){
        $result = $this->homeRepo->PrivacyPolicy();
        if($result['success']){
            if (Cache::has('privacy'))
                $privacy =  Cache::get('privacy');
            else {
                Cache::put('privacy', $result['object']['privacy'],now()->addMinutes(1440));
                $privacy =  Cache::get('privacy');
            }
            $lang_changed = $this->langChanged();
            return view('User.privacy_policy',compact('privacy','lang_changed'));
        }
        else
            abort(500);

    }

    /**
     * Show About us page
     *
     * @return view
     */
    public function about()
    {
        $lang_changed = $this->langChanged();
        return view('User.aboutus',compact('lang_changed'));
    }
    /**
     * Show Contact us page
     *
     * @return view
     */
    public function contact()
    {
        $lang_changed = $this->langChanged();
        return view('User.contactus',compact('lang_changed'));
    }
    /**
     * Show Join us page
     *
     * @return view
     */
    public function joinUs(){
        $lang_changed = $this->langChanged();
        return view('User.joinus',compact('lang_changed'));
    }
    /**
     *Store Companies Requests in DB
     *
     *@param CompanyRequestRequest $request
     *
     * @return RedirectToURL
     */
    public function storeCompanyRequest(CompanyRequestRequest $request){
            $this->homeRepo->setReq($request);
            $result = $this->homeRepo->storeCompanyRequest();
            if ($result['success'])
                return redirect()->route('user.request.sent')->with('companyRequestSent',$result['success']);
            elseif ($result['errors'])
                return redirect()->back()->with('error',$result['errors']);
            elseif ($result['validator'])
                return redirect()->back()->with('error',$result['validator']);
            else
                abort(500);
    }
    /**
     *Display categories in background
     *
     * @return \Illuminate\Http\JsonResponse
     */
	public function categoriesRender()
	{
    	$categories = Category::where('level','level1')->get();
        return response()->json([
            'categoriesWeb' => view('User.partials.categoriesWeb')->with('categories', $categories)->render(),
            'categoriesMobile' => view('User.partials.categoriesMobile')->with('categories', $categories)->render(),
        ]);
	}
    /**
     * This is a helper function used to get previous language locale
     *
     * @return $lang_changed 0?1
     */
    private function langChanged(){
        $lang_changed = 0;
        if(session()->has('current_lang') && session()->get('current_lang') !=app()->getLocale())
            $lang_changed = 1;
        session()->put('current_lang',app()->getLocale());

        return $lang_changed;
    }
}
