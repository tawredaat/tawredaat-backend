<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteMapRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SiteMap;
use Illuminate\Support\Facades\File;

class SiteMapController extends Controller
{
    public function viewSiteMap()
    {
        $MainTitle = 'Site Map';
        $SubTitle = 'Update';
        $setting = Setting::first();
        $siteMaps = SiteMap::all();
        return view('Admin._settings.siteMap', compact('MainTitle', 'SubTitle', 'setting', 'siteMaps'));
    }

    //store site map
    public function storeSiteMap(SiteMapRequest $request)
    {
        $fileName = $request->site_map->getClientOriginalName();
        SiteMap::create([
            'path' => $fileName
        ]);
         $request->site_map->move(public_path('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR), $fileName);
        // $request->site_map->move(public_path('/'), $fileName);
        return back()->with('_added', 'Site map has been updated successfully.');
    }

    public function destroy($id)
    {
        $sitemap = SiteMap::findOrFail($id);
        File::delete(public_path('/') . $sitemap->path);
        $sitemap->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    public function updateLevel2()
    {
        Category::where('level','level2')->update([
            'parent' => 1
        ]);
        return "done";
    }

    public function updateLevel3()
    {
        Category::where('level','level3')->update([
            'parent' => 2
        ]);
        return "done";
    }

    public function removeLevel1and2()
    {
        $categories = Category::where([ ['level','level1'],['id','!=',1] ])->orWhere([ ['level','level2'],['id','!=',2] ])->get();
        foreach ($categories as $category)
        {
            UploadFile::RemoveFile($category->image);
            $category->delete();
        }
        //Category::where([ ['level','level2'],['id','!=',2] ])->delete();
        return "done";
    }
}
