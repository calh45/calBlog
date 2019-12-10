<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Image;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create(Request $request) {
        if($request->hasFile("imageSave")) {
            $destinationToSave = public_path("/images/");
            $imageToSave = $request->file('imageSave');
            $imageName = date('YmdHis').".".$imageToSave->getClientOriginalExtension();
            $imageToSave->move($destinationToSave, $imageName);

            $imageModelToSave = new Image();
            $imageModelToSave->fileName = (string)$imageName;
            $imageModelToSave->save();

            $newPost = new Post();
            $newPost->userId = Auth::user()->getAuthIdentifier();
            $newPost->postType = "image";
            $newPost->content = $request->input("postContent");
            $newPost->image_id = $imageModelToSave->id;
            $newPost->save();

        }else {
            $newPost = new Post();
            $newPost->userId = Auth::user()->getAuthIdentifier();
            $newPost->postType = "written";
            $newPost->content = $request->input("postContent");
            $newPost->image_id = null;
            $newPost->save();

        }


        $allPosts = Post::all();
        $currentLoggedIn = Auth::user();
        return view("/home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);

    }

    public function delete(Request $request) {
        $postId = $request->input("postId");
        $toDelete = Post::all()->where("id", $postId)->first();
        $toDelete->delete();

        $allPosts = Post::all();
        $currentLoggedIn = Auth::user();
        return view("/home", ["allPosts" => $allPosts, "currentLoggedIn" => $currentLoggedIn]);
    }
}
