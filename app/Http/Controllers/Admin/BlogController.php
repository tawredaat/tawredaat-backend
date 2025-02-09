<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Helpers\UploadFile;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $MainTitle = 'Blogs';
        $SubTitle  = 'Add';
        return view('Admin._blogs.index',compact('MainTitle','SubTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function blogs()
    {
        $records = Blog::all();
        return Datatables::of($records)->make(true);
    }


    public function create()
    {
        $MainTitle = 'Blogs';
        $SubTitle  = 'Add';

        return view('Admin._blogs.create',compact('MainTitle','SubTitle'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();

        try {
            //upload new file
            if ($request->file('image'))
                $image =  UploadFile::UploadSinglelFile($request->file('image'),'blogs');
            else
                $image = null;


            Blog::create([
                'image' => $image,

                'en'   => [
                    'title'=> $input['title_en'],
                    'alt' => $input['alt_en'],
                    'description'=> $input['descri_en'],
                    'description_meta'=> $input['descri_meta_en'],
                    'tags'=> $input['tags_en'],
                    'tags_meta'=> $input['tags_meta_en'],
                    'slug' => $input['slug_en'],
                    'page_title' => $input['page_title_en'],
                    'meta_title' => $input['title_meta_en'],
                ],
                'ar'   => [
                    'title' => $input['title_ar'],
                    'alt' => $input['alt_ar'],
                    'description'=> $input['descri_ar'],
                    'description_meta'=> $input['descri_meta_ar'],
                    'tags'=> $input['tags_ar'],
                    'tags_meta'=> $input['tags_meta_ar'],
                    'slug' => $input['slug_ar'],
                    'page_title' => $input['page_title_ar'],
                    'meta_title' => $input['title_meta_ar'],
                ],
            ]);

            DB::commit();
            session()->flash('_added','Blog has been created Succssfuly');

            return redirect()->route('blogs.index');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $MainTitle = 'Blogs';
        $SubTitle  = 'Edit';
        $blog = Blog::findOrFail($id);
        return view('Admin._blogs.edit',compact('blog','MainTitle','SubTitle'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request, $id)
    {

        $blog = Blog::FindOrFail($id);
        $input = $request->all();

        DB::beginTransaction();

        try {
            $blog->translate('en')->title  = $input['title_en'];
            $blog->translate('ar')->title  = $input['title_ar'];
            $blog->translate('en')->alt   = $input['alt_en'];
            $blog->translate('ar')->alt   = $input['alt_ar'];
            $blog->translate('en')->description  = $input['descri_en'];
            $blog->translate('ar')->description  = $input['descri_ar'];
            $blog->translate('en')->description_meta  = $input['descri_meta_en'];
            $blog->translate('ar')->description_meta  = $input['descri_meta_ar'];
            $blog->translate('en')->tags  = $input['tags_en'];
            $blog->translate('ar')->tags  = $input['tags_ar'];
            $blog->translate('en')->tags_meta  = $input['tags_meta_en'];
            $blog->translate('ar')->tags_meta  = $input['tags_meta_ar'];
            $blog->translate('en')->slug  = $input['slug_en'];
            $blog->translate('ar')->slug  = $input['slug_ar'];
            $blog->translate('en')->page_title  = $input['page_title_en'];
            $blog->translate('ar')->page_title  = $input['page_title_ar'];
            $blog->translate('en')->meta_title  = $input['title_meta_en'];
            $blog->translate('ar')->meta_title  = $input['title_meta_ar'];
            //upload new file
            if ($request->file('image'))
            {
                if ($blog->image)
                    //Remove old file
                    UploadFile::RemoveFile($blog->image);

                $blog->image =  UploadFile::UploadSinglelFile($request->file('image'),'blogs');
            }
            $blog->save();
            DB::commit();
            session()->flash('_added','Blog data has been updated succssfuly');
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
        $blog = Blog::FindOrFail($id);
        //Remove old file
        if ($blog->image) {
            UploadFile::RemoveFile($blog->image);
        }
        $blog->delete();
        return response()->json([],200);

    }
}
