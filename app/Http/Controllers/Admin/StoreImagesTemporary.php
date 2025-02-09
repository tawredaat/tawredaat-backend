<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
class StoreImagesTemporary extends Controller
{
    public function __invoke(request $request)
    {
	   for($i=0; $i<count($request->file('images')); $i++)
	    {
	        $FileName = $request->file('images')[$i]->getClientOriginalName();
	        $request->file('images')[$i]->move(public_path().'/products/',$FileName);
			ProductImage::create(['image'=>$FileName]);
		}
        return response()->json(['success'=>$FileName]);

    }
}
