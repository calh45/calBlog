<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Image;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index($id) {
        $postToReturn = Post::all()->where("id", $id)->first();
        $commentsToReturn = $postToReturn->comments;
        $currentLoggedIn = Auth::user();
        $currentLoggedInId = $currentLoggedIn->id;

        return view("PostHome", ["postToReturn" => $postToReturn, "commentsToReturn" => $commentsToReturn, "currentLoggedIn" => $currentLoggedIn, "currentLoggedInId" => $currentLoggedInId]);


    }

    public function edit(Request $request) {
        $validatedData = $request->validate([
            "newPost" => "required|string|min:1"
        ]);
        $newContent = $validatedData["newPost"];
        Post::all()->where("id", $request->input("postId"))->first()->update(["content" => $newContent]);

        $allPosts = Post::paginate(10);
        $currentLoggedIn = Auth::user();
        return view("home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);
    }

    public function create(Request $request) {

        $validatedData = $request->validate([
            "postContent" => "required|string|min:1"
        ]);

        if($request->hasFile("imageSave")) {
            $destinationToSave = public_path("/images/");
            $imageToSave = $request->file('imageSave');
            $imageName = date('YmdHis').".".$imageToSave->getClientOriginalExtension();
            $imageToSave->move($destinationToSave, $imageName);

            $imageModelToSave = new Image();
            $imageModelToSave->fileName = (string)$imageName;
            $imageModelToSave->save();

            $newPost = new Post();
            $newPost->user_Id = Auth::user()->getAuthIdentifier();
            $newPost->postType = "image";
            $newPost->content = $validatedData["postContent"];
            $newPost->image_id = $imageModelToSave->id;
            $newPost->save();

        }else {
            $newPost = new Post();
            $newPost->user_Id = Auth::user()->getAuthIdentifier();
            $newPost->postType = "written";
            $newPost->content = $validatedData["postContent"];
            $newPost->image_id = null;
            $newPost->save();

        }


        $allPosts = Post::paginate(10);
        $currentLoggedIn = Auth::user();
        return view("home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);

    }

    public function delete(Request $request) {
        $postId = $request->input("postId");
        $toDelete = Post::all()->where("id", $postId)->first();
        $toDelete->delete();

        $allPosts = Post::paginate(10);
        $currentLoggedIn = Auth::user();
        return view("home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);
    }
}
