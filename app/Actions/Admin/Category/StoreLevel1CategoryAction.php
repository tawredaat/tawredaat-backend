<?php

namespace App\Actions\Admin\Category;

use App\Helpers\UploadFile;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreLevel1CategoryAction
{
    public function execute(Request $request)
    {
        // upload image
        if ($request->file('image')) {
            $img = UploadFile::UploadSinglelFile($request->file('image'), 'categories');
        } else {
            $img = null;
        }

        Category::create([
            'parent' => null,
            'level' => 'level1',
            'image' => $img,
            'en' => [
                'name' => $request->name_en,
                'title' => $request->title_en,
                'alt' => $request->alt_en,
                'description' => $request->descri_en,
                'description_meta' => $request->descri_meta_en,
                'keywords_meta' => $request->keywords_meta_en,
                'keywords' => $request->keywords_en,

            ],
            'ar' => [
                'name' => $request->name_ar,
                'title' => $request->title_ar,
                'alt' => $request->alt_ar,
                'description' => $request->descri_ar,
                'description_meta' => $request->descri_meta_ar,
                'keywords_meta' => $request->keywords_meta_ar,
                'keywords' => $request->keywords_ar,

            ],
        ]);

    }
}
