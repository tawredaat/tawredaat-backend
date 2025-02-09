<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

//use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Brand extends Model implements TranslatableContract
{
    /*protected $fillable =[
    'name_en',
    'name_ar',
    'categories',
    'image',
    'alt_en',
    'alt_ar',
    'keywords_ar',
    'keywords_en',
    'keywords_meta',
    'title_ar',
    'title_en',
    'description_en',
    'description_ar',
    'description_meta_ar',
    'description_meta_en',
    'origin',
    'pdf'
    ];    */
    use Translatable;
    public $translatedAttributes = ['name', 'alt', 'keywords', 'keyword_meta', 'title', 'description', 'description_meta', 'products_title', 'products_description', 'products_keywords', 'distributors_title', 'distributors_description', 'distributors_keywords'];

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }
    public function brandCategories()
    {
        return $this->hasMany('App\Models\BrandCategory', 'brand_id');
    }
    public function brandCompanies()
    {
        return $this->hasMany('App\Models\CompanyProduct', 'brand_id');
    }
    public function countCompanies($key = null, $keyword = null, $category = null)
    {
        $brands_in_category = [];
        if ($category) {
            $brands_in_category = BrandCategory::where('category_id', $category->id)->distinct()->pluck('brand_id')->toArray();
            foreach ($brands_in_category as $br) {
                if (!in_array($br, $brands_in_category)) {
                    array_push($brands_in_category, $br);
                }

            }
        }
       
        return Company::join('company_products', 'companies.id', '=', 'company_products.company_id')
            ->when($key, function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')->orWhere('keywords', 'like', '%' . $key . '%');
                });
            })->when($keyword, function ($query) use ($keyword) {
            return $query->whereHas('translations', function ($query) use ($keyword) {
                $query->where('keywords', 'like', '%' . $keyword . '%');
            });
        })->when($brands_in_category, function ($query) use ($brands_in_category) {
            return $query->whereNotNull('company_products.product_id')->whereIn('company_products.brand_id', $brands_in_category);
        })->whereNotNull('company_products.product_id')->where('company_products.brand_id', $this->id)->where('hidden', 1)->groupBy('companies.id')->get()->count();
    }
    public function brandTypeCompanies()
    {
        return $this->hasMany('App\Models\CompanyBrand', 'brand_id')->groupBy('company_id', 'company_type_id');
    }
    public function products($key = null, $category = null, $company = null)
    {
        //if inside categories
        $categories = [];
        $category = Category::find($category);
        if ($category && $category->level == 'level1') {
            $categories_childs = $category->childs->pluck('id')->toArray();
            $categories = Category::where('level', 'level3')->whereIn('parent', $categories_childs)->pluck('id')->toArray();
        } elseif ($category && $category->level == 'level2') {
            $categories = $category->childs->pluck('id')->toArray();
        } elseif ($category && $category->level = 'level3') {
            array_push($categories, $category->id);
        }

        return $this->hasMany('App\Models\Product', 'brand_id')->when($key, function ($query) use ($key) {
            return $query->whereHas('translations', function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')->orWhere('sku_code', 'like', '%' . $key . '%');
            })->whereHas('brand', function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->orWhere('name', 'like', '%' . $key . '%');
                });
            })->whereHas('category', function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->orWhere('name', 'like', '%' . $key . '%');
                });
            });
        })->with([
            'translations' => function ($query) {$query->select(['locale', 'name', 'product_id']);},
            'category' => function ($query) {$query->select(['id']);},
            'brand' => function ($query) {$query->select(['id']);},
        ])->when($categories, function ($query) use ($categories) {
            return $query->whereIn('category_id', $categories);
        })->when($company, function ($query) use ($company) {
            return $query->whereIn('id', CompanyProduct::where('company_id', $company->id)->whereNotNull('product_id')->pluck('product_id')->toArray());
        })->select(['id', 'brand_id', 'category_id', 'image', 'sku_code']);
    }

    public function slug()
    {
        $slug_en = BrandTranslation::where('locale' , 'en')->where('brand_id' , $this->id)->get('name')->toArray();
        return Str::slug($slug_en[0]['name']);
    }
}