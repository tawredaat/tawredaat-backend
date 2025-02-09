<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Country extends Model implements TranslatableContract
{
    use Translatable;

    protected $primaryKey = 'id';
    public $incrementing = true;

    public $translatedAttributes = ['name', 'alt'];
    public function brands($key = null, $keyword = null, $category = null)
    {
        return $this->hasMany('App\Models\Brand', 'country_id')->when($key, function ($query) use ($key) {
            return $query->whereHas('translations', function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')->orWhere('keywords', 'like', '%' . $key . '%');
            });
        })->when($category, function ($query) use ($category) {
            return $query->whereHas('brandCategories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            });
        })->when($keyword, function ($query) use ($keyword) {
            return $query->whereHas('translations', function ($query) use ($keyword) {
                $query->where('keywords', 'like', '%' . $keyword . '%');
            });
        })->get();
    }
    public function products($key = null, $category = null, $company = null)
    {

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

        $countryBrands = Brand::where('country_id', $this->id)->groupBy('id')->pluck('id')->toArray();
        return Product::when($key, function ($query) use ($key) {
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
        ])->select(['id', 'brand_id', 'category_id', 'image', 'sku_code'])->whereIn('brand_id', $countryBrands)
            ->when($categories, function ($query) use ($categories) {
                return $query->whereIn('category_id', $categories);
            })->when($company, function ($query) use ($company) {
            return $query->whereIn('id', CompanyProduct::where('company_id', $company->id)->whereNotNull('product_id')->pluck('product_id')->toArray());
        })->get();
    }
}
