<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Category;
use App\Comment;
use App\Image;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Show individual Post insight page.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id) {
        $postToReturn = Post::all()->where("id", $id)->first();
        $commentsToReturn = $postToReturn->comments;
        $currentLoggedIn = Auth::user();
        $currentLoggedInId = $currentLoggedIn->id;

        return view("PostHome", ["postToReturn" => $postToReturn, "commentsToReturn" => $commentsToReturn, "currentLoggedIn" => $currentLoggedIn, "currentLoggedInId" => $currentLoggedInId]);


    }


    /**
     * Responsible for editing an existing Post model
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit(Request $request) {
        //Validate entered new content of model
        $validatedData = $request->validate([
            "newPost" => "required|string|min:1"
        ]);

        //Update Post model
        $newContent = $validatedData["newPost"];
        Post::all()->where("id", $request->input("postId"))->first()->update(["content" => $newContent]);

        //Delete existing Category tags in pivot table for this Post model
        $postToEdit = Post::all()->where("id", $request->input("postId"))->first();
        $categoriesToDelete = DB::table("category_post")->where("post_id", $postToEdit->id);
        $categoriesToDelete->delete();

        //Create new entries for selected Categories into Category pivot table
        foreach ($_POST['editCategories'] as $categories) {
            $postToEdit->categories()->attach($categories);
        }

        return redirect(route("home"));
    }

    /**
     * Responsible for creating a Post model
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request) {

        //Validate content of Post to be created
        $validatedData = $request->validate([
            "postContent" => "required|string|min:1"
        ]);


        //Create Image model then Post model if a Image file has been added, create just Post model if not
        if($request->hasFile("imageSave")) {
            //Store uploaded Image within application
            $destinationToSave = public_path("/images/");
            $imageToSave = $request->file('imageSave');
            $imageName = date('YmdHis').".".$imageToSave->getClientOriginalExtension();
            $imageToSave->move($destinationToSave, $imageName);

            //Create Image model
            $imageModelToSave = new Image();
            $imageModelToSave->fileName = (string)$imageName;
            $imageModelToSave->save();

            //Create Post model with attatched Image model
            $newPost = new Post();
            $newPost->user_Id = Auth::user()->getAuthIdentifier();
            $newPost->postType = "image";
            $newPost->content = $validatedData["postContent"];
            $newPost->image_id = $imageModelToSave->id;
            $newPost->save();

            //Create Activity model for this new Post
            $this->createActivity($validatedData["postContent"], $newPost->id);

        }else {
            //Create Post model with no Image
            $newPost = new Post();
            $newPost->user_Id = Auth::user()->getAuthIdentifier();
            $newPost->postType = "written";
            $newPost->content = $validatedData["postContent"];
            $newPost->image_id = null;
            $newPost->save();

            //Create Activity model for this new Post
            $this->createActivity($validatedData["postContent"], $newPost->id);

        }


        //Insert entries into Category pivot table for each Category tag selected
        if(isset($_POST['categories'])) {
            foreach ($_POST['categories'] as $categories) {
                $newPost->categories()->attach($categories);
            }
        }



        return redirect(route("home"));

    }

    /**
     * Responsible for deleting an existing Post model
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request) {
        //Find Post model to delete
        $postId = $request->input("postId");
        $toDelete = Post::all()->where("id", $postId)->first();

        //Delete Post model
        $toDelete->delete();

        return redirect(route("home"));
    }

    /**
     * Responsible for creating Activity model
     * @param $content
     * @param $postId
     */
    public function createActivity($content, $postId) {
        $activityToCreate = new Activity();
        $activityToCreate->activity_type="Post";
        $activityToCreate->content=$content;
        $activityToCreate->user_id=Auth::user()->getAuthIdentifier();
        $activityToCreate->post_id=$postId;
        $activityToCreate->save();
    }
}
