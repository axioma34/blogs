<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
class CommentController extends Controller
{

    public function show($post_id)
    {
        $comments = Comment::where('post_id',$post_id)->get();
        return $comments->toArray();
    }

    public function store ($post_id,Request $request)
    {
        try {
            $post = Post::find($post_id);
        } catch(\Illuminate\Database\QueryException $ex){
            return response()->json($ex->getMessage());
        }
        if (!$post)
        {
            return response('Post with this id does not exist');
        }
        $validator = Validator::make( $request->get(['payload'][0]), [
            'author' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $comment = Comment::create([
            'post_id' => $post->id,
            'author' => $request->get(['payload'][0])['author'],
            'comment' => $request->get(['payload'][0])['comment'],
            'created_at' => Carbon::now()
        ]);

        return response()->json($comment);

    }

    public function destroy (Comment $comment)
    {
        $comment->delete();
        return response()->json('Comment with this id '."$comment->id".' was deleted');
    }
}
