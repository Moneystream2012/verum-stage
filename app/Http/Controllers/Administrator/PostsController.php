<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use App\UnreadUserPost;
use App\User;

class PostsController extends Controller
{
    public function index()
    {
        $data = Post::latest()->get();

        return view('administrator.posts.index', compact('data'));
    }

    public function create()
    {
        return view('administrator.posts.create');
    }

    public function store(PostRequest $request)
    {
        Post::create($request->only(['title', 'body', 'body_ru']));
        User::get(['id'])->each(function ($user) {
            UnreadUserPost::firstOrCreate(['user_id' => $user->id])
                ->increment('unread');
        });
        flash()->success('News Create!')->important();

        return redirect()->route('administrator.posts.index');
    }

    public function edit(Post $post)
    {
        return view('administrator.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->only(['title', 'body', 'body_ru']));
        flash()->success('News Update!')->important();

        return redirect()->back();
    }

    public function destroy(Post $post)
    {
        $post->delete();
        flash()->success('News Delete!')->important();

        return redirect()->back();
    }
}
