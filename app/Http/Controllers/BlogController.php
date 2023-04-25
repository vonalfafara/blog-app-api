<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Blog;
use App\Http\Resources\BlogResource;
use App\Http\Resources\BlogShowResource;
use App\Http\Resources\UserBlogResource;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = $request->query('order') ? $request->query('order') : 'desc';

        return BlogResource::collection(Blog::select('id', 'user_id', 'title', 'subtitle', 'created_at', 'updated_at')
            ->orderBy('created_at', $order)
            ->paginate(5));
    }

    /**
     * Search by title.
     */
    public function search(Request $request) {
        $order = $request->query('order') ? $request->query('order') : 'desc';
        $search_term = '%' . $request->query('term') . '%';
        return BlogResource::collection(Blog::where('title', 'LIKE', $search_term)
        ->orderBy('created_at', $order)
        ->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'body' => 'required|string',
            'image' => 'nullable|string'
        ]);

        $blog = Blog::create([
            'user_id' => auth()->user()->id,
            'title' => $fields['title'],
            'subtitle' => $fields['subtitle'],
            'body' => $fields['body'],
            'image' => $fields['image'],
        ]);

        return response($blog, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(BlogShowResource::make(Blog::find($id)), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'body' => 'required|string',
            'image' => 'nullable|string'
        ]);

        $blog = Blog::find($id);
        $blog->update($request->all());

        return response($blog, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Blog::destroy($id);

        $response = [
            'message' => 'Blog deleted'
        ];

        return response($response, 200);
    }

    public function getUserBlogs(string $id) {
        $blogs = Blog::where('user_id', $id)->paginate(5);

        return BlogResource::collection($blogs);
    }
}
