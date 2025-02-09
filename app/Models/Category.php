<?php

namespace App\Models;
use Illuminate\Support\Str;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

//use Illuminate\Database\Eloquent\Model;

class Category extends Model implements TranslatableContract
{
    /*protected $fillable =[
    'name_en',
    'parent',
    'name_ar',
    'image',
    'alt_en',
    'alt_ar',
    'keyword',
    'keyword_meta',
    'title',
    'level',
    'descri_en',
    'descri_ar',
    'descri_meta_ar',
    'descri_meta_en'];*/
    use Translatable;
    public $translatedAttributes = ['name', 'alt', 'keywords', 'keywords_meta', 'title', 'description', 'description_meta'];

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }
    
    // Define the inverse relationship with bundles
    public function bundles()
    {
        return $this->belongsToMany(Bundle::class, 'bundel_category');
    }

    public function shopProducts()
    {
        return $this->hasMany('App\Models\ShopProduct')
                    ->where('show', 1); // Adding the where condition for shopProducts
    }

    public function parent_category()
    {
        return $this->belongsTo('App\Models\Category', 'parent');
    }

    public function childs()
    {
        return $this->hasMany('App\Models\Category', 'parent')
                    ->where('show', 1); // Example condition
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
            })->whereNotNull('company_products.product_id')->whereIn('company_products.brand_id', BrandCategory::where('category_id', $this->id)->distinct()->pluck('brand_id')->toArray())->where('hidden', 1)->groupBy('companies.id')->get()->count();
    }
    public function products($key = null, $company = null, $brand = null)
    {
        return $this->hasMany('App\Models\Product', 'category_id')->when($key, function ($query) use ($key) {
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
            'translations' => function ($query) {
                $query->select(['locale', 'name', 'product_id']);
            },
            'category' => function ($query) {
                $query->select(['id']);
            },
            'brand' => function ($query) {
                $query->select(['id', 'image']);
            },
        ])->when($company, function ($query) use ($company) {
            return $query->whereIn('id', CompanyProduct::where('company_id', $company->id)->whereNotNull('product_id')->pluck('product_id')->toArray());
        })->when($brand, function ($query) use ($brand) {
            return $query->where('brand_id', $brand->id);
        })->select(['id', 'brand_id', 'category_id', 'image', 'sku_code'])->inRandomOrder();
    }

    public function brands($key = null, $keyword = null, $category = null)
    {
        return $this->hasMany('App\Models\BrandCategory', 'category_id')->when($key, function ($query) use ($key) {
            return $query->whereHas('brand', function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')->orWhere('keywords', 'like', '%' . $key . '%');
                });
            });
        })->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category->id);
        })->when($keyword, function ($query) use ($keyword) {
            return $query->whereHas('brand', function ($query) use ($keyword) {
                return $query->whereHas('translations', function ($query) use ($keyword) {
                    $query->where('keywords', 'like', '%' . $keyword . '%');
                });
            });
        })->get();
    }

    public function homeBanners()
    {
        return CategoryBanner::where('category_id', $this->id)->where('home', '1')->first();
    }

    public function homeBrands()
    {
        $brands = CategoryHomeBrand::where('category_id', $this->id)->pluck('brand_id')->toArray();
        return Brand::whereIn('id', $brands)->get();
    }

    public function homeCategories()
    {
        $categories = CategoryHomeCategory::where('parent_category_id', $this->id)->pluck('child_category_id')->toArray();
        return Category::whereIn('id', $categories)->get();
        
    }

    public function slug()
    {
        $slug = CategoryTranslation::where('locale' , 'en')->where('category_id' , $this->id)->get('name');
        return Str::slug($slug[0]['name']);
    }
}
