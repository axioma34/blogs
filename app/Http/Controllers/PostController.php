<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $posts = Post::limit($request->limit)->offset($request->offset)->get();
        return $posts->toArray();
    }

    public function show(Post $post)
    {
     return $post->toArray();
    }

    public function store (Request $request)
    {
        $validator = Validator::make($request->get(['payload'][0]), [
            'title' => 'required|string|max:255|unique:posts',
            'text' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        if (array_key_exists('short_text', $request->get(['payload'][0])))
        {
            $short_text = $request->get(['payload'][0])['short_text'];
        }
        else
        {
            $short_text = null;
        }

        $post = Post::create([
            'title' => $request->get(['payload'][0])['title'],
            'text' => $request->get(['payload'][0])['text'],
            'short_text' => $short_text,
            'created_at' => Carbon::now()
        ]);

        return $post->toArray();

    }

    public function destroy (Post $post)
    {
        $post->delete();
        return response()->json('Post with this id '."$post->id".' was deleted');
    }
}
