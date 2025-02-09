<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable implements TranslatableContract
{
    use Notifiable;
    use Translatable;
    protected $fillable = [
        'logo', 'alt', 'name', 'description', 'description_meta', 'keywords_meta', 'keywords', 'date', 'title',
        'brochure', 'price_lists', 'sales_mobile', 'company_phone','whatsup_number','company_email', 'address', 'map', 'facebook', 'insta', 'twitter', 'youtube', 'linkedin', 'pri_contact_phone'
        , 'pri_contact_email', 'pri_contact_name', 'password', 'gold_sup', 'hidden', 'featured', 'rank','products_title','products_description','products_keywords'
    ];
    public $translatedAttributes = ['name','title','alt','address','description','description_meta','keywords_meta','keywords','products_title','products_description','products_keywords'];

    public function subscriptions()
    {
        return $this->hasOne(CompanySubscription::class);
    }

    public function areas()
    {
        return $this->belongsToMany('App\Models\Area');
    }
    public function brands($key=null, $keyword=null, $category=null)
    {
        return $this->hasMany('App\Models\CompanyProduct','company_id')->distinct()->when($key, function ($query) use ($key) {
			return $query->whereHas('brand', function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')->orWhere('keywords', 'like', '%' . $key . '%');
                });
            });
		})->when($category, function ($query) use ($category) {
            return $query->whereHas('brand', function ($query) use ($category) {
                return $query->whereHas('brandCategories', function ($query) use ($category) {
                        $query->where('category_id',$category->id);
                });
            });
		})->when($keyword, function ($query) use ($keyword) {
			return $query->whereHas('brand', function ($query) use ($keyword) {
                return $query->whereHas('translations', function ($query) use ($keyword) {
                    $query->where('keywords', 'like', '%' . $keyword . '%');
                });
            });
		})->groupBy('brand_id')->get();
    }
    public function products()
    {
        return $this->hasMany('App\Models\CompanyProduct')->whereNotNull('product_id')->distinct();
    }

    public function allProducts()
    {
        return $this->hasManyThrough('App\Models\Product','App\Models\CompanyProduct');
    }

    public function countProducts($key=null,$category=null)
    {
        $categories = [];
		$category = Category::find($category);
		if($category && $category->level=='level1'){
            $categories_childs = $category->childs->pluck('id')->toArray();
            $categories = Category::where('level','level3')->whereIn('parent',$categories_childs)->pluck('id')->toArray();
        }elseif($category && $category->level=='level2')
			$categories = $category->childs->pluck('id')->toArray();
        elseif($category && $category->level='level3')
			array_push($categories,$category->id);

        $companyProducts = CompanyProduct::where('company_id',$this->id)->whereNotNull('product_id')->pluck('product_id')->toArray();
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
			'translations' => function ($query) { $query->select(['locale','name','product_id']);},
			'category' => function ($query) { $query->select(['id']);},
			'brand' => function ($query) {$query->select(['id']);},
        ])->select(['id',  'brand_id','category_id','image','sku_code'])->whereIn('id',$companyProducts)
        ->when($categories, function ($query) use ($categories) {
			return $query->whereIn('category_id', $categories);
		})->get()->count();
    }
    public function company_types()
    {
        return $this->belongsToMany('App\Models\CompanyType');
    }
    public function certificates()
    {
        return $this->hasMany('App\Models\Certificate');
    }
    public function branches()
    {
        return $this->hasMany('App\Models\Branch');
    }
    public function members()
    {
        return $this->hasMany('App\Models\TeamMember');
    }
    public function generalRfqs()
    {
        $this->hasMany(GeneralRfq::class);
    }
    public function hasProducts(){
      $countProducts =   \App\Models\CompanyProduct::where('company_id',$this->id)->first();
      if($countProducts)
          return 1;
     return 0;
    }


    public function rfq_isResponded($id){

        $rfq_responses = RfqResponse::where('company_id',$this->id)->where('rfq_id',$id)->count();
        if($rfq_responses > 0){
            return 1;

        }else{
            return 0;
        }

    }


    public function getRfqResponse($id){
        $rfq_responses = RfqResponse::where('company_id',$this->id)->where('rfq_id',$id)->first();
        return $rfq_responses->responseDescription;
    }

    public function rfqResponseStatus($id){
        $rfq_responses = RfqResponse::where('company_id',$this->id)->where('rfq_id',$id)->first();
        return $rfq_responses->status;

    }
}
