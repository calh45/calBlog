<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request) {
        $newComment = new Comment();
        $newComment->userId = Auth::user()->getAuthIdentifier();
        $newComment->postId = $request->input("postId");
        $newComment->content = $request->input("enteredComment");
        $newComment->save();

        $allPosts = Post::all();
        $currentLoggedIn = Auth::user();
        return view("/home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);

    }

    public function delete(Request $request) {
        $commentId = $request->input("commentId");
        $toDelete = Comment::all()->where("id", $commentId)->first();
        $toDelete->delete();

        $allPosts = Post::all();
        $currentLoggedIn = Auth::user();
        return view("/home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);
    }
}
