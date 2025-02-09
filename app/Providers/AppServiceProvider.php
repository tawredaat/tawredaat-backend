<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
Use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->composer('User.partials.header', function ($view){
        //     $categories = Category::where('level','level1')->get();
            //     $lang = app()->getLocale();
        //     if (Cache::has('categoriesWebEn')) {
        //         $categoriesWebEn = Cache::get('categoriesWebEn');
        //     }else{
        //         app()->setLocale('en');
        //         $categoriesWebEn = view('User.partials.categoriesWeb')->with('categories', $categories)->render();
        //     }
        //     if (Cache::has('categoriesWebAr')) {
        //         $categoriesWebAr = Cache::get('categoriesWebAr');
        //     }else{
        //         app()->setLocale('ar');
        //         $categoriesWebAr = view('User.partials.categoriesWeb')->with('categories', $categories)->render();
        //     }

        //     if (Cache::has('categoriesMobileEn')) {
        //         $categoriesMobileEn = Cache::get('categoriesMobileEn');
        //     }else{
        //         app()->setLocale('en');
        //         $categoriesMobileEn = view('User.partials.categoriesMobile')->with('categories', $categories)->render();
        //     }
        //     if (Cache::has('categoriesMobileAr')) {
        //         $categoriesMobileAr = Cache::get('categoriesMobileAr');
        //     }else{
        //         app()->setLocale('ar');
        //         $categoriesMobileAr = view('User.partials.categoriesMobile')->with('categories', $categories)->render();
        //     }
        //     app()->getLocale($lang);

        //     $view->with([
        //     'categoriesMobileEn'=> $categoriesMobileEn,
        //     'categoriesMobileAr'=> $categoriesMobileAr,
        //     'categoriesWebEn'=> $categoriesWebEn,
        //     'categoriesWebAr'=> $categoriesWebAr]);

        // });
        $setting = Setting::first();
        View::share('setting', $setting);

        View::composer(['User.partials.header'], function ($view) {
            if (App::isLocale('en')) {
                $newLocal = '/ar';
                $string = 'عربي';
                $alt = __('home.ElectricalEquipment') . '|egy-img-flag';
                $img = asset('frontend_plugins/web/images/egy-flag.png');
            } else {
                $newLocal = '';
                $string = 'EN';
                $alt = __('home.ElectricalEquipment') . '|usa-img-flag';
                $img = asset('frontend_plugins/web/images/usa.png');
            }
            if(request()->path() == '/' || request()->path() == 'ar')
                $url =url($newLocal);
            else
            $url = url('/') . $newLocal . str_replace(['/en/', '/ar/'], '/', '/' . request()->path() . (request()->query() ? '?' . request()->getQueryString() : ''));
            $view->with([
                'changeLangUrl' => $url,
                'changeLangString' => $string,
                'changeLangAlt' => $alt,
                'changeLangImg' => $img
            ]);
        });

        Schema::enableForeignKeyConstraints();
        Schema::defaultStringLength(191);
    }
}