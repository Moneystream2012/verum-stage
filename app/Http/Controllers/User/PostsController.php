<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Post;
use App\UnreadUserPost;

class PostsController extends Controller
{
    public function index()
    {
        $data = Post::latest()->get();

        UnreadUserPost::where('unread', '>', 0)
            ->where('user_id', auth()->id())
            ->update(['unread' => 0]);

        return view('unify.personal-office.posts', compact('data'));
    }
}
