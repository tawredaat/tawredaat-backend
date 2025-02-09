<?php

namespace App\Http\Controllers\User\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Blog;
use App\Http\Resources\Collections\BlogsCollection;
use App\Http\Resources\BlogResource;

class BlogController extends BaseResponse
{
    public function index(Request $request)
    {
        $blogs = Blog::orderBy('created_at','desc')->paginate(6)->appends($request->except('page'));
        $results['blogs'] = new BlogsCollection($blogs);
        $results['pagination'] = General::createPaginationArray($blogs);
        $results['total'] = $results['pagination']['total'];
        return $this->response(200, "All Blogs", 200, [], 0, $results);
    }

    public function show(Request $request, $id)
    {
        $blog = Blog::find($id);
        if(!$blog)
            return $this->response( 101, "Validation Error", 200, 'This blog is not found');
        $results['blog'] =  new BlogResource($blog);
        return $this->response(200,"All Blogs",200,[],0,$results);
    }
}
