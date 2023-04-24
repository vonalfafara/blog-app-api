<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = $request->query('order') ? $request->query('order') : 'desc';
        return Blog::select('user_id', 'title', 'subtitle', 'created_at', 'updated_at')
                    ->orderBy('created_at', $order)
                    ->paginate();
    }

    /**
     * Search by title.
     */
    public function search(Request $request) {
        $order = $request->query('order') ? $request->query('order') : 'desc';
        $search_term = '%' . $request->query('term') . '%';
        return Blog::where('title', 'like', $search_term)
                    ->orWhere('subtitle', 'like', $search_term)
                    ->orWhere('body', 'like', $search_term)
                    ->orderBy('created_at', $order)
                    ->paginate();
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
        $blog = Blog::find($id);
        $blog->user;
        $blog->comments;
        
        return response($blog, 200);
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
}
