<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repository\User\ProductRepo;
class CategoryController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;

    }
    /**
     * Filter products usign categories
     *
     * @param Request $request, $name, $id
     *
     * @return colloection of data
     */
    public function productsFilterByCategories(Request $request,$name,$id)
    {
        $category = Category::findOrFail($id);
        $request->merge(['in_category' => $category->id]);
        $request->merge(['category_level' => $category->level]);
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if ($result['success'])
        {
            $category = $result['object']['category'];
            $countProducts = $result['object']['total'];
            $categoryName    = $category->name;
            $categoryID = $category->id;
            $category_level = $category->level;
            $categoryTitle = $category->title;
            $categoryArName = $category->translate('ar')->name;
            $categoryEnName = $category->translate('en')->name;
            $categoryMetaDesc = $category->description_meta;
            $categoryMetakeywords = $category->keywords_meta;
            $products = $result['object']['products'];
            $products_ids = $result['object']['products_ids'];
            $categories = $result['object']['categories'];
            $brands = $result['object']['brands'];
            $companies = $result['object']['companies'];
            $countries = $result['object']['countries'];
            $specifications = $category->level=='level3'?json_decode(json_encode($result['object']['specifications'])):[];
            $lang_changed = $this->langChanged();
            return view('User.products_categories',compact('products_ids','countProducts','products','categories','categoryEnName','categoryName','categoryArName','categoryID','categoryTitle','countries','companies','brands','category_level','categoryMetaDesc','categoryMetakeywords','specifications','lang_changed'));
        }
        elseif ($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * This is a helper function used to get previous language locale
     *
     * @return $lang_changed 0?1
     */
    private function langChanged(){
        $lang_changed = 0;
        // $adBanner 		= AdBanner::first();
        if(session()->has('current_lang') && session()->get('current_lang') !=app()->getLocale())
            $lang_changed = 1;
        session()->put('current_lang',app()->getLocale());

        return $lang_changed;
    }
}
