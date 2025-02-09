<?php

namespace App\Http\Resources;

use App\Http\Resources\Collections\CategoriesCollection;
use App\Models\Category;
use App\Models\CategoryBanner;
use App\Models\ShopProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public $searchSelection;
    public $view;
    /**
     * CategoryResource constructor.
     * @param $resource
     */
    public function __construct($resource, $searchSelection = 0, $view = null)
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;
        $this->view = $view;

    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $childs = $this->childs;

        if ($this->view == 'shop' && $this->level == 'level1') {
            $childs = $this->childs->whereIn('id', Category::where('level', 'level3')->whereIn('id', ShopProduct::distinct()->pluck('category_id')->toArray())->distinct()->pluck('parent')->toArray());
            return [
                'id' => intval($this->id),
                'selected' => intval($this->searchSelection),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                'banners' => CategoryBannerResource::collection(
                    CategoryBanner::where('category_id', $this->id)->where('home' , 1)->get()
                ),
                'childs' => new CategoriesCollection($childs, [], $this->view) 
            ];

        }

        if ($this->view == null && $this->level == 'level1') {
            // $childs = $this->childs->whereIn('id', Category::where('level', 'level3')->whereIn('id', ShopProduct::distinct()->pluck('category_id')->toArray())->distinct()->pluck('parent')->toArray());
            return [
                'id' => intval($this->id),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                'banners' => CategoryBannerResource::collection(
                    CategoryBanner::where('category_id', $this->id)->where('home' , 1)->get()
                ),
                // 'childs' => new CategoriesCollection($childs, [], $this->view)
            ];

        }

        if ($this->view == 'shop' && $this->level == 'level2') {
            $childs = $this->childs->whereIn('id', ShopProduct::distinct()->pluck('category_id')->toArray());
            return [
                'id' => intval($this->id),
                'selected' => intval($this->searchSelection),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                'childs' => new CategoriesCollection($childs, [], $this->view)
            ];
        }

        if ($this->view == null && $this->level == 'level2') {
            $childs = $this->childs->whereIn('id', ShopProduct::distinct()->pluck('category_id')->toArray());
            return [
                'id' => intval($this->id),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                //'childs' => new CategoriesCollection($childs, [], $this->view)
            ];
        }

        if ($this->view == 'shop' && $this->level == 'level3') {
            $products = ShopProduct::where(['category_id' => $this->id,
                'featured' => 1])->get();

            return [
                'id' => intval($this->id),
                'selected' => intval($this->searchSelection),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                'childs' => ShopProductResource::collection($products),
            ];
        }

        if ($this->view == null && $this->level == 'level3') {
            // $products = ShopProduct::where(['category_id' => $this->id,
            //     'featured' => 1])->get();

            return [
                'id' => intval($this->id),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                // 'childs' => ShopProductResource::collection($products),
            ];
        }

    }
}
