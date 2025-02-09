<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    /*protected $fillable =[
    'name_en',
    'name_ar',
    'category_id',
    'brand_id',
    'image',
    'images',
    'alt_en',
    'alt_ar',
    'keywords_ar',
    'keywords_en',
    'keywords_meta_en',
    'keywords_meta_ar',
    'title_ar',
    'title_en',
    'description_en',
    'description_ar',
    'description_meta_ar',
    'description_meta_en',
    'video',
    'pdf',
    'sku_code'
    ];      */
    use Translatable;
    public $translatedAttributes = ['name', 'alt', 'title', 'keywords', 'keywords_meta', 'description', 'description_meta'];
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function specifications()
    {
        return $this->hasMany('App\Models\ProductSpecification', 'product_id');
    }
    public function companyProducts()
    {
        return $this->hasMany('App\Models\CompanyProduct', 'product_id')->groupBy('company_id');
    }
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //return images belongs to product
    public function images()
    {
        return $this->morphMany('App\Models\File', 'model');
    }

    public function getBestRankCompany()
    {
        $companyIds = $this->companyProducts->pluck('company_id');
        $bestRankCompanyNumber = Company::whereIn('id', $companyIds)->orderBy('rank', 'desc')->first();

        if (!is_null($bestRankCompanyNumber)) {
            return $bestRankCompanyNumber['company_phone'];
        } else {
            return null;
        }

    }
}
