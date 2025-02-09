<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Area extends Model implements TranslatableContract
{
	use Translatable;
	public $translatedAttributes = ['name'];
    public function companies($key = null, $keyword=null, $category=null){
    	$brands_in_category = [];
		if($category){
			$brands_in_category = BrandCategory::where('category_id',$category->id)->distinct()->pluck('brand_id')->toArray();
            foreach ($brands_in_category as $br) {
                if (!in_array($br,$brands_in_category))
                    array_push($brands_in_category, $br);
            } 
        }
        return $this->belongsToMany('App\Models\Company')->when(($key or $keyword or $category), function ($query) use ($key,$keyword,$category,$brands_in_category) {
            $query->when($key, function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')->orWhere('keywords', 'like', '%' . $key . '%');
                });
            })->when($keyword, function ($query) use ($keyword) {
                return $query->whereHas('translations', function ($query) use ($keyword) {
                    $query->where('keywords', 'like', '%' . $keyword . '%');
                });
            })->when($brands_in_category, function ($query) use ($brands_in_category) {
                return $query->join('company_products',   'companies.id', '=', 'company_products.company_id')->whereNotNull('company_products.product_id')->whereIn('company_products.brand_id', $brands_in_category);
            })->where('hidden',1)->groupBy('companies.id')->get();
        })->where('hidden',1)->groupBy('companies.id')->get();
    }

}
