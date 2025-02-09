<?php

namespace App\Repository\User;
use App\Http\Controllers\Controller;

use App\Http\Resources\Collections\CategoriesCollection;
use App\Models\BrandCategory;
use App\Models\Company;
use App\Models\CompanyProduct;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRfq;
use App\Models\Rfq;
use App\Models\RfqCategory;
use App\Models\RfqResponse;
use App\Models\CompanyBrand;
use App\Http\Resources\RfqResource;
use App\Http\Resources\RfqResponseResource;
use App\Http\Resources\Collections\RfqsCollection;
use App\Http\Resources\Collections\RfqResponsesCollection;
use App\Http\Resources\Collections\ProductRfqsCollection;
use Illuminate\Support\Facades\DB;
use App\Jobs\UserRFQSendConfirmationJob;
// use App\Jobs\SendRFQsToCompanyJob;

class RfqRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }

    public function allLevelThree()
    {
        $results['categories'] = new CategoriesCollection(Category::where('level','level3')->get());
        return $this->result = ['validator' => null, 'success' => 'all level one categories','errors'=>null,'object'=>$results];
    }

    public function store()
    {
        $request = $this->request;
        DB::beginTransaction();
        try{
            if(count($request->description) == count($request->category_id) && count($request->category_id) == count($request->quantity))
            {
                $rfq = new Rfq();
                $rfq->user_id = auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id;
                $rfq->save();
                for ($i = 0 ; $i < count($request->category_id) ;$i++){
                    $rfq_category = new RfqCategory();
                    $rfq_category->rfq_id = $rfq->id;
                    $rfq_category->category_id = $request->category_id[$i];
                    $rfq_category->description = $request->description[$i];
                    $rfq_category->quantity = $request->quantity[$i];
                    $rfq_category->save();
                }
                // $BrandCategoryIDs = BrandCategory::WhereIn('category_id',$request->input('category_id'))->distinct()->pluck('brand_id');
                // $companyIds = CompanyBrand::WhereIn('brand_id',$BrandCategoryIDs)->distinct()->pluck('company_id');
                // $companies = Company::find($companyIds);
                // $companies_job = (new SendRFQsToCompanyJob($companies, $rfq))->delay(\Carbon\Carbon::now()->addSeconds(2));
                // dispatch($companies_job);

                $user_job = (new UserRFQSendConfirmationJob(auth()->user()))->delay(\Carbon\Carbon::now()->addSeconds(2));
                dispatch($user_job);
                DB::commit();
                return $this->result = ['validator' => null, 'success' => __('home.RFQSent'),'errors'=>null];
            }
            return $this->result = ['validator' => ['Enter valid data'],'success'=>null,'errors'=>null,'object'=>null];

        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }

    public function getRfqs()
    {
        $results['rfqs'] = new RfqsCollection(Rfq::where('user_id',(auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id))->orderBy('id','DESC')->get());
        //$results['productsRfq'] = new ProductRfqsCollection(ProductRfq::where('user_id',auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->get());
        return $this->result = ['validator' => null, 'success' => 'View Products & Categories RFQs','errors'=>null,'object'=>$results];
    }
    /**
     * Get RFQ responses belong to user.
     *
     * @return colloection of data
     */
    public function getRfqResponses($id)
    {
        set_time_limit(0);
        DB::beginTransaction();
        try{
            $rfq = Rfq::where('user_id',(auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id))->find($id);
            if($rfq){
                $rfq_responses = RfqResponse::where('rfq_id',$id)->where('status',null)->get();
                $rfq_accept = RfqResponse::where('rfq_id',$id)->where('status',1)->count();
                //return $rfq_accept;
                if($rfq_accept >0)
                    $accept = RfqResponse::where('rfq_id',$id)->where('status',1)->first();
                else
                    $accept = null;
                $results['rfq'] = new RfqResource($rfq);
                $results['responses'] = new RfqResponsesCollection($rfq_responses);
                $results['accept'] = $accept;
                return $this->result = ['validator' => null, 'success' =>'success','errors'=>null,'object'=>$results];
            }
            return $this->result = ['validator' => ['Rfq not found'], 'success' => null,'errors'=>null,'object'=>null];
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }

    public function accept($id)
    {
        DB::beginTransaction();
        try{
            $rfq_response = RfqResponse::whereIn('rfq_id',Rfq::where('user_id',auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->pluck('id')->toArray())->find($id);
            if($rfq_response){
                $rfq_response->status = 1;
                $rfq_response->save();
                /*$rfqs = Rfq::where('user_id',auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->get();
                $results['rfq_responce'] = new RfqResponseResource($rfq_response);
                $results['rfqs'] = new RfqsCollection($rfqs);*/
                DB::commit();
                return $this->result = ['validator' => null, 'success' => __('home.rfqAccepted'),'errors'=>null];
            }
            return $this->result = ['validator' => ['Rfq response not found'], 'success' => null,'errors'=>null,'object'=>null];
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }

    public function reject($id)
    {
        DB::beginTransaction();
        try{
            $rfq_response = RfqResponse::whereIn('rfq_id',Rfq::where('user_id',auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->pluck('id')->toArray())->find($id);
            if($rfq_response){
                $rfq_response->status = 2;
                $rfq_response->save();
                /*$rfqs = Rfq::where('user_id',auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->get();
                $results['rfq_responce'] = new RfqResponseResource($rfq_response);
                $results['rfqs'] = new RfqsCollection($rfqs);*/
                DB::commit();
                return $this->result = ['validator' => null, 'success' => __('home.rfqRejected'),'errors'=>null];
            }
            return $this->result = ['validator' => ['Rfq response not found'], 'success' => null,'errors'=>null,'object'=>null];
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }

    public function companyResponse($id)
    {
        $rfq_responses = RfqResponse::where('rfq_id',$id)->get();
        if($rfq_responses){
            $results['responses'] = new RfqResponsesCollection($rfq_responses);
            DB::commit();
            return $this->result = ['validator' => null, 'success' => 'RFQ company response','errors'=>null,'object'=>$results];
        }
        return $this->result = ['validator' => 'Rfq Response Not found', 'success' => null,'errors'=>null,'object'=>null];
}
    /**
     * Get Products RFQs List.
     *
     * @return colloection of data
     */
    public function getProductRfqs(){
        set_time_limit(0);
        DB::beginTransaction();
        try{
            $results['productsRfqs'] = new ProductRfqsCollection(ProductRfq::where('user_id',auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->get());
            return $this->result = ['validator' => null, 'success' => 'success','errors'=>null,'object'=>$results];
        }catch (\Exception $exception){
            DB::rollback();
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
     /**
     * Send Product RFQ.
     *
     *
     *@return colloection of data
     */
    public function sendProductRFQ()
    {
        set_time_limit(0);
        $request = $this->request;
        DB::beginTransaction();
        try{
            $is_sended = ProductRfq::where('user_id',auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->where('company_id',$request->input('company_id'))->where('company_product_id',$request->input('product_id'))->count();
            if($is_sended >0)
                $response = 0;
            else{
                if($request->input('company_id')){
                    $product_rfq = ProductRfq::create([
                        'user_id'=>auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id,
                        'company_id'=>$request->input('company_id'),
                        'company_product_id'=>$request->input('product_id'),
                    ]);
                    $response = 1;
                    DB::commit();
                }
            }
            $results['response'] = $response;
            return $this->result = ['validator' => null, 'success' => 'success','errors'=>null,'object'=>$results];
        }catch (\Exception $exception){
            DB::rollback();
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
    /**
     * Send product rfq best selling.
     *@param $id
     *@return colloection of data
     */
    public function productRfqBestSelling($id)
    {
        set_time_limit(0);
        $request = $this->request;
        DB::beginTransaction();
        try{
            $product = Product::find($id);
            if($product){
                $company_products = $product->companyProducts;
                $counter = 0;
                foreach ($company_products as $company_product) {
                    ProductRfq::where('user_id', auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->where('company_id', $company_product->company_id)->where('company_product_id', $company_product->id)->delete();
                    $is_sended = ProductRfq::where('user_id', auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id)->where('company_id', $company_product->company_id)->where('company_product_id', $company_product->id)->count();
                    if ($is_sended > 0)
                        $response = 0;
                    else{
                        $counter++;
                        $product_rfq = ProductRfq::create([
                            'user_id'=>auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id,
                            'company_id'=>$company_product->company_id,
                            'company_product_id'=>$company_product->id,
                            'notes'=>$request->input('notes'),
                            'qty'=>$request->input('qty'),
                        ]);
                        $response = 1;
                        DB::commit();
                    }
                }
                // $results['counter'] = $counter;
                return $this->result = ['validator' => null, 'success' => __('home.sentBestPricesRequest'),'errors'=>null,'object'=>null];
            }
            return $this->result = ['validator' => ['Product Not found'], 'success' => null,'errors'=>null,'object'=>null];
        }catch (\Exception $exception){
            DB::rollback();
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
}
