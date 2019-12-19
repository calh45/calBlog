<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{

    /**
     * Responsible for returning JSON collection of all Comment models for use with axios in view
     * @param $postId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function apiIndex($postId) {
        //Get all Comments for a specified Post
        $commentsToReturn = Comment::with("user")->where("post_id", $postId)->get();

        return $commentsToReturn;

    }

    /**
     * Responsible for creating a Comment model for use with axios in view
     * @param Request $request
     * @param $postId
     * @param $userId
     * @return Comment
     */
    public function apiCreate(Request $request, $postId, $userId) {

        //Validation of entered data for Comment model
        $validatedData = $request->validate([
            "name" => "required|string|min:1"
        ]);

        //Create Comment model
        $newComment = new Comment();
        $newComment->user_id = $userId;
        $newComment->post_id = $postId;
        $newComment->content = $validatedData["name"];
        $newComment->save();

        //Call to create an Activity model for this Comment
        $this->createActivity($validatedData["name"], $postId, $userId);

        return $newComment;
    }

    /**
     * Responsible for editing a Comment model.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request) {

        //Validation of entered Comment data
        $validatedData = $request->validate([
            "newComment" => "required|string|min:1"
        ]);

        $commentToFind = $request->input("commentId"); //Find Comment model to edit
        $commentContent = $validatedData["newComment"]; //Retrieve content for new comment

        //Update Comment model
        Comment::all()->where("id", $commentToFind)->first()->update(["content" => $commentContent]);

        return redirect(route("home"));
    }

    /**
     * Responsible for standard creation of a Comment (no axios)
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request) {

        //Validation of entered Comment data
        $validatedData = $request->validate([
            "enteredComment" => "required|string|min:1"
        ]);

        //Create Comment model
        $newComment = new Comment();
        $newComment->userId = Auth::user()->getAuthIdentifier();
        $newComment->postId = $request->input("postId");
        $newComment->content = $validatedData["enteredComment"];
        $newComment->save();

        return redirect(route("home"));

    }

    /**
     * Responsible for deleting a Comment model
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request) {
        //Find Comment model to delete
        $commentId = $request->input("commentId");
        $toDelete = Comment::all()->where("id", $commentId)->first();

        //Delete Comment model
        $toDelete->delete();

        return redirect(route("home"));
    }

    /**
     * Responsible for creating an Activity model
     * @param $content
     * @param $postId
     * @param $userId
     */
    public function createActivity($content, $postId, $userId) {
        $activityToCreate = new Activity();
        $activityToCreate->activity_type="Comment";
        $activityToCreate->content=$content;
        $activityToCreate->user_id=$userId;
        $activityToCreate->post_id=$postId;
        $activityToCreate->save();
    }
}
