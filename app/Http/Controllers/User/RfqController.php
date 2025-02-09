<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SendRfq;
use App\Http\Requests\User\StoreProductRfqBestSelling;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRfq;
use App\Models\Rfq;
use Illuminate\Http\Request;
use App\Repository\User\CategoryRepo;
use App\Repository\User\RfqRepo;

class RfqController extends Controller
{

    protected $categoryRepo;
    protected $rfqRepo;
    public function __construct(CategoryRepo $categoryRepo, RfqRepo $rfqRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->rfqRepo = $rfqRepo;
    }
    /**
     * Create RFQ page
     *
     * @return View
     */
    public function rfq(){
        $result = $this->categoryRepo->levelThreeCategories();
        if($result['success']){
            $categories = $result['object']['levelThreeCategories'];
            $lang_changed = $this->langChanged();
            return view('User.rfq',compact('categories','lang_changed'));
        }else
            abrot(500);

    }
    /**
     * Store RFQ in DB
     *
     * @param SendRfq $request
     *
     * @return View
     */
    public function sendRfq(SendRfq $request){
       $this->rfqRepo->setReq($request);
       $result = $this->rfqRepo->store();
       if($result['success'])
            return redirect()->route('user.request.sent')->with('RFQsent',$result['success']);
       else
            abort(500);
    }
    /**
     * Get RFQs Belongs to a user
     *
     * @return View
     */
    public function rfqList(){
       $result = $this->rfqRepo->getRfqs();
       if($result['success']){
            $rfqs = $result['object']['rfqs'];
            $lang_changed = $this->langChanged();
            return view('User.rfq_list',compact('rfqs','lang_changed'));
       }else
            abort(500);

    }
    /**
     * Get rfq Responses Belongs an RFQ
     *
     * @param $id
     *
     * @return View
     */
    public function rfqResponses($id){
        $result = $this->rfqRepo->getRfqResponses($id);
        if($result['success']){
             $rfq_responses = $result['object']['responses'];
             $accept = $result['object']['accept'];
             $lang_changed = $this->langChanged();
             return view('User.rfq_responses',compact('rfq_responses','accept','lang_changed'));
        }
        elseif($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * Accept Rfq
     *
     * @param $id
     *
     * @return View
     */
    public function Acceptrfq($id){
        $result = $this->rfqRepo->accept($id);
        if($result['success']){
             $rfqs = $result['object']['rfqs'];
             $lang_changed = $this->langChanged();
            session()->flash('_added',$result['success']);
             return view('User.rfq_list',compact('rfqs','lang_changed'));
        }
        elseif($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * Reject Rfq
     *
     * @param $id
     *
     * @return View
     */
    public function Refuserfq($id){
        $result = $this->rfqRepo->reject($id);
        if($result['success']){
             $rfqs = $result['object']['rfqs'];
             $lang_changed = $this->langChanged();
            session()->flash('_added',$result['success']);
             return view('User.rfq_list',compact('rfqs','lang_changed'));
        }
        elseif($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * Get Products rfq list
     *
     * @param Request $request
     *
     * @return View
     */
    public function productRfqList(){

        $result = $this->rfqRepo->getProductRfqs();
        if($result['success']){
            $rfqs = $result['object']['productsRfqs'];
            $lang_changed = $this->langChanged();
            return view('User.product_rfq_list',compact('rfqs','lang_changed'));
        }
    }
    /**
     * Send Product RFQ
     *
     * @param Request $request
     *
     * @return View
     */
    public function sendProductRfq(Request $request){
       $this->rfqRepo->setReq($request);
       $result = $this->rfqRepo->sendProductRFQ();
       if($result['success'])
           return response()->json($result['object']['response']);
        else
            return response()->json([]);
     }
    /**
     * Sent product Rfq best selling
     *
     * @param Request $request
     *
     * @return View
     */
    public function productRfqBestSelling(StoreProductRfqBestSelling $request, $id){
       $this->rfqRepo->setReq($request);
        $result = $this->rfqRepo->productRfqBestSelling($id);
        if($result['success'])
        {
            return response()->json(['success'=>$result['success']],200);
            // if($result['object']['counter'] == 0)
            //     return back()->with('success','Product quotation may be has been sent successfully to the companies, Wait response !');
            // else
            //     return back()->with('success','Product quotation  has been sent successfully to the companies, Wait response !');
        }elseif($result['validator'])
            return response()->json(['validator'=>$result['validator']],200);
        else
            return response()->json([]);
    }
    /**
     * This is a helper function used to clone categories after add new category
     *
     * @param  Request  $request
     * @return HTMLContent
     */
    public  function clone(Request  $request){
        $categories = Category::where('level','level3')->get();
        $output ='';
        $options = '';
        foreach($categories as $cat){
                $options .='<option value = "'.$cat->id.'" >'.$cat->name.'</option >';
        }
        $output .='<div class="col-lg-6"><label class="rfq-label">'.__('home.selectCategory').' <a href="#" style="font-size:15px;margin:10px;color: #000;" title="Remove this row" class="delete_category"><i class="fa fa-times"></i></a> </label><br><select name="category_id[]" required=""class="form-control m-input m-input--square"id="exampleSelect1">'.$options.'</select></div><div class="col-lg-6"><label  class="rfq-label">'.__('home.description').'</label><br><textarea  name="description[]"  required="" class="form-control m-input" style="background:#fff !important;" placeholder="'.__('home.descriptionRFQ').'"></textarea></div>';
        return $output;
    }
    /**
     * This is a helper function used to get previous language locale
     *
     * @return $lang_changed 0?1
     */
    private function langChanged(){
        $lang_changed = 0;
        if(session()->has('current_lang') && session()->get('current_lang') !=app()->getLocale())
            $lang_changed = 1;
        session()->put('current_lang',app()->getLocale());
        return $lang_changed;
    }
}
