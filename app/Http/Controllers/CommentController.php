<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function apiIndex($postId) {
        $commentsToReturn = Comment::all()->where("post_id", $postId);

        return $commentsToReturn;

    }

    public function apiCreate(Request $request, $postId, $userId) {
        $newComment = new Comment();
        $newComment->user_id = $userId;
        $newComment->post_id = $postId;
        $newComment->content = $request["name"];
        $newComment->save();

        return $newComment;
    }

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
