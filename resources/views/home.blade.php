
<link href="{{ asset('css/homepage.css') }}" rel="stylesheet">

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                    <div class = "formContainer">
                        <form class="formStyle" method="POST" enctype="multipart/form-data" action={{ route("post.create") }}>
                            {{ csrf_field() }}
                            <input class="postInput" id="postContent" name="postContent" type="text" placeholder="Write a post...">
                            <input type="file" id="imageSave" name="imageSave" >
                            <input type="checkbox" name="imageUpload"> Upload with Image
                            <button class="postButton" type="submit"> Post </button>

                        </form>
                    </div>

                @foreach($allPosts as $currentPost)
                    <div class="postContainer">
                        <div class="postHeader">
                            <div class="postName">
                                {{ $currentPost->user->name }}
                                <div class="postDate">
                                    {{ $currentPost->created_at }}
                                </div>
                            </div>
                        </div>
                        {{ $currentPost->content }}

                        @if($currentPost->postType == "image")
                            <img src="/images/{{ $currentPost->image->fileName }}" alt="Image">
                        @endif
                        <div>Comments: </div>
                        @foreach($currentPost->comments as $currentComment)
                            <div>
                                {{ $currentComment->user->name }} - {{ $currentComment->created_at }}
                            </div>
                            <div class="commentBox"> {{ $currentComment->content }} </div>
                            @if($currentComment->user_id == $currentLoggedIn->id)
                                <button> Edit </button>
                                <form method="post" action="{{ route("comment.delete") }}">
                                    {{ csrf_field() }}
                                    <input name="commentId" type="hidden" value={{ $currentComment->id }}>
                                    <button type="submit"> Delete </button>
                                </form>
                            @endif
                        @endforeach
                        <form method="POST" action={{ route("comment.create") }}>
                            {{ csrf_field() }}
                            <input name="postId" type="hidden" value={{ $currentPost->id }}>
                            <input class="commentBox" id="enteredComment" name="enteredComment" type="text" placeholder="Write a comment...">
                            <div class="commentsAndDeleteButton">
                                <button type="submit"> Comment </button>
                            </div>
                        </form>

                        @if($currentPost->user_id == $currentLoggedIn->id)
                            <button> Edit </button>
                            <form method="post" action="{{ route("post.delete") }}">
                                {{ csrf_field() }}
                                <input name="postId" type="hidden" value={{ $currentPost->id }}>
                                <button type="submit"> Delete </button>
                            </form>
                        @endif

                    </div>

                @endforeach

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

