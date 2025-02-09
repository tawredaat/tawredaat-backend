<?php

namespace App\Actions\Vendor\ShopProduct;

use App\Models\VendorShopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetOffersDataAction
{
    public function execute(Request $request)
    {
        $pagination = 0;
        if ($request->input('pagination') == 'true') {
            $pagination = 500;
        } else {
            $pagination = 10;
        }

        //return $pagination;
        $products = VendorShopProduct::where('old_price', '>', 'new_price')->whereNotNull('new_price')->when($request->input('column'), function ($query) use ($request) {
            if ($request->input('column') == 'name') {
                return $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('value') . '%');
                });
            }

            if ($request->input('column') == 'brand') {
                return $query->whereHas('brand', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }

            if ($request->input('column') == 'category') {
                return $query->whereHas('category', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }
        })->with(['category' => function ($query) use ($request) {
            $query->select(['id']);
        },
            'brand' => function ($query) use ($request) {
                $query->select(['id']);
            }])
            ->select(['id', 'brand_id', 'category_id', 'image', 'old_price', 'new_price', 'created_at', 'featured'])
            ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
                $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
            })->when($request->input('column') == 'id', function ($query) use ($request) {
                return $query->where('id', 'like', '%' . $request->input('value') . '%');
            })->orderBy('id', 'DESC')->paginate($pagination)->appends([
                'column' => $request->input('column'),
                'value' => $request->input('value'),
                'image' => $request->input('image'),
            ]);
        $result = '';
        foreach ($products as $product) {
            $result .= '<tr id="tr-' . $product->id . '">';
            $result .= '<td >';
            $result .= '<input form="deleteForm" type="checkbox" name="products[]" value="' . $product->id . '">';
            $result .= '</td >';
            $result .= '<td >';
            $result .= '<img src="' . asset('storage/' . $product->image) . '" width="80">';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->name;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->old_price;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->new_price;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->brand ? $product->brand->name : '-';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->category ? $product->category->name : '-';
            $result .= '</td >';
            $result .= '<td >';
            $result .= '<a class="btn-sm btn btn-primary"  href=' . route('vendor.shop-products.specifications', $product->id) . ' title="view specifications">' . count($product->specifications) . '</a> <a class="btn-sm btn btn-primary featured" id="shop-product-' . $product->id . '" ' . ($product->featured ? 'title ="Remove this product from featured in home page" style="color:red !important"' : 'title ="Make this product featured in home page"') . '  data-content="' . $product->id . '"><i class="fa fa-fire"></i></a> <a class="btn-sm btn btn-primary"  href=' . route('shop.products.images', $product->id) . ' title="view images"><i class="far fa-images"></i></a> <a title="edit product" class="btn-sm btn btn-primary"  href=' . route('shop.products.edit', $product->id) . '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn-sm btn btn-danger delete" title="remove this product from offers!" data-content="' . $product->id . '"><i class="fa fa-times"></i></a>';
            $result .= ' </td >';
            $result .= ' </tr >';
        }

        return [
            'products' => $products,
            'result' => $result,
        ];
    }
}
