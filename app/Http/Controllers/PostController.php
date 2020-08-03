<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{    
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * dashboard
     *
     * @return void
     */
    public function dashboard()
    {
        $posts = Post::latest()->get();
        return view('dashboard', [
            'posts' => $posts
        ]);
    }
        
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $post = new Post;
        $post->body = $request->body;
        Auth::user()->posts()->save($post);

        return redirect('/dashboard')->with('success', 'Post was created successfully!');
    }

    public function update(Request $request)
    {
        $post = Post::find($request->postId);
        // $user_id = $post->user_id;

        // if(Auth::id() !== $user_id)
        // {
        //     return response([
        //         'message' => "You  can't edit this post!"
        //     ]);
        // }

        // return response([
        //     $post
        // ]);

        if(Gate::denies('update', $post)){
            return response([
                'message' => "You can't edit this post!"
            ]);
        }

        $this->validate($request, [
            'body' => 'required'
        ]);

        $post->body = $request->body;
        $post->save();
        return response([
            'message' => "Post was update successfully!",
            'body' => $request->body
        ]);
    }

    public function destroy(Post $post)
    {
        if(Gate::denies('delete', $post)){
            return redirect()->route('dashboard')->with('error', "You don't have permission to delete this posts!");
        }
        // $this->authorize('update', $post);
        $post->delete();
        return redirect()->route('dashboard')->with('success', 'Post was deleted successfully!');
    }
    
    /**
     * postLike
     *
     * @param  mixed $request
     * @return void
     */
    public function postLike(Request $request)
    {
        $like = $request->islike === 'true';
        $postId = (int) $request->postId;
        $user = Auth::user();
        $post = Post::find($postId);

        if(!($post))
        {
            return null;
        }

        $is_like = $user->likes()->where('post_id', $postId)->first();
        if($is_like)
        {
            if($like == $is_like->like) // boolean == tinyInt(boolean)
            {
                $is_like->delete();
                return response([
                    'remove' => [
                        $is_like
                    ]
                ]);
            }
            else
            {
                $is_like->like = $like;
                $is_like->update();
                return response([
                    'data' => [
                        $is_like
                    ]
                ]);
            }
            
        }
        else
        {
            $newlike = new Like;
            $newlike->post_id = $postId;
            $newlike->like = $like;
            $user->likes()->save($newlike);
            return response([
                'data' => [
                    $newlike
                ]
            ]);
        }
    }
}
