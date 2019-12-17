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

    public function edit(Request $request) {
        $commentToFind = $request->input("commentId");
        $commentContent = $request->input("newComment");

        Comment::all()->where("id", $commentToFind)->first()->update(["content" => $commentContent]);

        $allPosts = Post::paginate(10);
        $currentLoggedIn = Auth::user();
        return view("home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);
    }

    public function create(Request $request) {
        $newComment = new Comment();
        $newComment->userId = Auth::user()->getAuthIdentifier();
        $newComment->postId = $request->input("postId");
        $newComment->content = $request->input("enteredComment");
        $newComment->save();

        $allPosts = Post::paginate(10);
        $currentLoggedIn = Auth::user();
        return view("home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);

    }

    public function delete(Request $request) {
        $commentId = $request->input("commentId");
        $toDelete = Comment::all()->where("id", $commentId)->first();
        $toDelete->delete();

        $allPosts = Post::paginate(10);
        $currentLoggedIn = Auth::user();
        return view("home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);
    }
}
