<?php

namespace App\Actions\Admin\CategoryBrandStorePage;

use App\Models\CategoryBrandStorePage;

class DestroyAction
{
    public function execute($id)
    {
        $category_brand_store_page = CategoryBrandStorePage::findOrFail($id);
        CategoryBrandStorePage::where('category_id',
            $category_brand_store_page->category_id)->delete();
    }
}
