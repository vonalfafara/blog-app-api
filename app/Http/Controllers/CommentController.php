<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $fields = $request->validate([
            'blog_id' => 'required|numeric',
            'body' => 'required|string'
       ]);

       $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'blog_id' => $fields['blog_id'],
            'body' => $fields['body']
       ]);

       return response($comment, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fields = $request->validate([
            'body' => 'required|string'
        ]);
        
        $comment = Comment::find($id);
        $comment->update($request->all());

        return response($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comment::destroy($id);

        $response = [
            'message' => 'Comment deleted'
        ];

        return response($response, 200);
    }
}
