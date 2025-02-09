<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\CategoryBanner;
use App\Models\ShopProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithSubCategoriesWithoutProductsResource extends JsonResource
{
    public $searchSelection;
    /**
     * CategoryResource constructor.
     * @param $resource
     */
    public function __construct($resource, $searchSelection = 0)
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;
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

        if ($this->level == 'level1') {
            $childs = $this->childs->whereIn('id',
                Category::where('level', 'level3')
                    ->whereIn('id', ShopProduct::distinct()
                            ->pluck('category_id')->toArray())->distinct()->pluck('parent')->toArray());
            return [
                'id' => intval($this->id),
                'selected' => intval($this->searchSelection),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                'banners' => CategoryBannerResource::collection(
                    CategoryBanner::where('category_id', $this->id)->get()
                ),
                'childs' => CategoryWithSubCategoriesWithoutProductsResource::collection($childs, [])
            ];

        }

        if ($this->level == 'level2') {
            $childs = $this->childs->whereIn('id', ShopProduct::distinct()
                    ->pluck('category_id')->toArray());

            return [
                'id' => intval($this->id),
                'selected' => intval($this->searchSelection),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                'childs' => CategoryWithSubCategoriesWithoutProductsResource::collection($childs, [])
            ];
        }

        if ($this->level == 'level3') {
            return [
                'id' => intval($this->id),
                'selected' => intval($this->searchSelection),
                'name' => $this->name,
                'slug' => $this->slug(),
                'image' => $this->image ? asset('storage/' . $this->image) : null,
                'alt' => $this->alt,
                'level' => str_replace("level", "", $this->level),
                'childs' => [],
            ];
        }
    }
}
