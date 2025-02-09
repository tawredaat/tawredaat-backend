<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\OfferPackage;
use App\Models\OfferPackageGift;
use App\Models\QuantityType;
use App\Http\Requests\Admin\OfferPackageRequest;
use App\Http\Requests\Admin\DeleteSelectedOffersRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OfferPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MainTitle = 'Offer Packages';
        $SubTitle  = 'View';
        return view('Admin._offer_packages.index',compact('MainTitle','SubTitle'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $MainTitle = 'Offer Packages';
        $SubTitle  = 'Add';
        $shopProducts = ShopProduct::all();
        $quantityTypes = QuantityType::all();

        return view('Admin._offer_packages.create',compact('MainTitle','SubTitle','shopProducts','quantityTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferPackageRequest $request)
    {
        DB::beginTransaction();
        try{
            $offer = OfferPackage::create([
                'shop_product_id'=>$request->input('shop_product_id'),
                'shop_product_qty'=>$request->input('shop_product_qty'),
                'quantity_type_id'=>$request->input('shop_product_qty_type'),
                'price'=>$request->input('price'),
            ]);
            if($offer){
                foreach($request->input('gift_products') as $index=>$gift){
                    OfferPackageGift::create([
                        'offer_package_id'=>$offer->id,
                        'shop_product_id'=>$gift,
                        'gift_qty'=>$request->input('gift_qtys')[$index],
                        'quantity_type_id'=>$request->input('gift_qty_types')[$index],

                    ]);
                }
            }
            DB::commit();
            session()->flash('_added','Offer package  created Succssfuly');
            return redirect()->route('shop.offerPackages.index');
        }catch (\Exception $exception) {
            DB::rollback();
           abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $MainTitle = 'Offer Packages';
       $SubTitle  = 'Edit';
       $offer = OfferPackage::findOrFail($id);
       $shopProducts = ShopProduct::all();
       $quantityTypes = QuantityType::all();
       return view('Admin._offer_packages.edit',compact('offer','MainTitle','SubTitle','shopProducts','quantityTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfferPackageRequest $request, $id)
    {
        Db::beginTransaction();
        try{
            $offer=OfferPackage::findOrFail($id);
            $offer->shop_product_id  = $request->input('shop_product_id');
            $offer->shop_product_qty  = $request->input('shop_product_qty');
            $offer->quantity_type_id  = $request->input('shop_product_qty_type');
            $offer->price  = $request->input('price');
            $offer->save();
            if($offer && is_array($request->input('gift_products'))){
                $offer->gifts()->delete();
                foreach($request->input('gift_products') as $index=>$gift){
                    OfferPackageGift::create([
                        'offer_package_id'=>$offer->id,
                        'shop_product_id'=>$gift,
                        'gift_qty'=>$request->input('gift_qtys')[$index],
                        'quantity_type_id'=>$request->input('gift_qty_types')[$index],

                    ]);
                }
            }
            DB::commit();
            session()->flash('_updated','Offer Package updated succssfuly');
            return back();
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Db::beginTransaction();
        try{
            $offerPackage= OfferPackage::findOrFail($id);
            $offerPackage->delete();
            DB::commit();
            return response()->json(['id'=>$id],200);
        }catch (\Exception $exception) {
            DB::rollback();
            return response()->json([],200);
        }
    }
    /**
     * Remove the specified selected resource from storage.
     *
     * @param  DeleteSelectedOffersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(DeleteSelectedOffersRequest $request)
    {
        Db::beginTransaction();
        try{
            $offers = OfferPackage::whereIn('id', $request->input('offers', []))->get();
            foreach ($offers as $offer)
                $offer->delete();
            DB::commit();
            session()->flash('_added', 'Offers data has been deleted successfully');
            return back();
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Remove all offer packages.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll()
    {
        Db::beginTransaction();
        try{
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('offer_packages')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::commit();
            session()->flash('_added', 'Offers data has been deleted successfully');
            return back();
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    //get offers packages
    public function getOffers(Request $request)
        {
            ini_set('memory_limit', '1024M'); // or you could use 1G
            //return $request->all();
            $pagination = 0;
            if($request->input('pagination') == 'true')
                $pagination = 500;
            else
                $pagination =10;
            //return $pagination;
            $offers = OfferPackage::when($request->input('column'), function ($query) use ($request) {
                if ($request->input('column') == 'qty')
                    return  $query->where('shop_product_qty', 'like', '%' . $request->input('value') . '%');
                if ($request->input('column') == 'qty_type')
                    return $query->whereHas('quantityType', function ($query) use ($request) {
                        return $query->whereHas('translations', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('value') . '%');
                        });
                    });
                if ($request->input('column') == 'price')
                    return  $query->where('price', 'like', '%' . $request->input('value') . '%');
                if ($request->input('column') == 'name')
                    return $query->whereHas('shopProduct', function ($query) use ($request) {
                        return $query->whereHas('translations', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('value') . '%');
                        });
                    });

            })->with(['shopProduct' => function ($query) use ($request) {
                $query->select(['id','image']);
            },])
                ->select(['id','shop_product_id', 'price', 'quantity_type_id', 'shop_product_qty', 'created_at'])
                ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
                })->when($request->input('column') == 'id', function ($query) use ($request) {
                    return $query->where('id', 'like', '%' . $request->input('value') . '%');
                })->paginate($pagination)->appends([
                    'column' => $request->input('column'),
                    'value' => $request->input('value'),
                ]);
            $result = '';
            foreach ($offers as $offer) {
                $result .= '<tr id="tr-' . $offer->id . '">';
                $result .= '<td >';
                $result .= '<input form="deleteForm" type="checkbox" name="offers[]" value="' . $offer->id . '">';
                $result .= '</td >';
                $result .= '<td >';
                $result .= '<img src="' . asset('storage/' . ($offer->shopProduct?$offer->shopProduct->image:'---')) . '" width="80">';
                $result .= '</td >';
                $result .= '<td >';
                $result .= $offer->shopProduct?$offer->shopProduct->name:'---';
                $result .= '</td >';
                $result .= '<td >';
                $result .= $offer->shop_product_qty;
                $result .= '</td >';
                $result .= '<td >';
                $result .= $offer->quantity_type_id?$offer->quantityType->name:'--';
                $result .= '</td >';
                $result .= '<td >';
                $result .= $offer->price;
                $result .= '</td >';
                $result .= '<td >';
                $result .= '<a class="btn btn-primary"  href=' . route('shop.offerPackages.edit', $offer->id) . '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="' . $offer->id . '"><i class="fa fa-trash"></i></a>';
                $result .= ' </td >';
                $result .= ' </tr >';
            }
            return response()->json(['result' => $result, 'links' => $offers->links()->render()], 200);
        }
}
