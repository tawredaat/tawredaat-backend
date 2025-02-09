<?php

namespace App\Actions\Admin\Category;

use App\Helpers\UploadFile;
use App\Models\Category;

class DestroyLevel1Action
{
    public function execute($id)
    {
        $category = Category::where('level', 'level1')->findOrFail($id);

        // Remove old single file
        if ($category->image) {
            UploadFile::RemoveFile($category->image);
        }

        $category->delete();
    }
}
