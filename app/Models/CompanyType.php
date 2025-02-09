<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class CompanyType extends Model implements TranslatableContract
{

    use Translatable;
    public $translatedAttributes = ['name'];
    protected $table = 'company_types';

    public function types()
    {
        return $this->hasMany('App\Models\CompanyBrand', 'company_type_id');
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

        return Company::join('company_company_type', 'companies.id', '=', 'company_company_type.company_id')
            ->when($key, function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')->orWhere('keywords', 'like', '%' . $key . '%');
                });
            })->when($keyword, function ($query) use ($keyword) {
            return $query->whereHas('translations', function ($query) use ($keyword) {
                $query->where('keywords', 'like', '%' . $keyword . '%');
            });
        })->when($brands_in_category, function ($query) use ($brands_in_category) {
            return $query->join('company_products', 'companies.id', '=', 'company_products.company_id')->whereNotNull('company_products.product_id')->whereIn('company_products.brand_id', $brands_in_category);
        })->where('company_company_type.company_type_id', $this->id)->where('hidden', 1)->groupBy('companies.id')->get()->count();
    }
}
