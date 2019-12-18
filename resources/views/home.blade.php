<link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <p class="errorMessage"> <b> {{ $error }} </b></p>
                    @endforeach

                @endif
                    <div class = "formContainer">
                        <form class="formStyle" method="POST" enctype="multipart/form-data" action={{ route("post.create") }}>
                            {{ csrf_field() }}
                            <input class="postInput" id="postContent" name="postContent" type="text" placeholder="Write a post...">
                            <input type="file" id="imageSave" name="imageSave" >
                            <input type="checkbox" name="imageUpload"> Upload with Image
                            <button class="postButton" type="submit"> Post </button>
                            <div class="categoryBanner">Categories:</div>
                            <div class="categoryContainer">
                                @foreach($categories as $currentCategory)
                                    <input type="checkbox" value="{{ $currentCategory->id }}" id="{{ $currentCategory->id }}" name="categories[]"> {{ $currentCategory->name }}
                                @endforeach
                            </div>

                        </form>
                    </div>

                @foreach($allPosts as $currentPost)
                    <div class="postContainer">
                        <div class="postHeader">
                            <div class="postName">
                                {{ $currentPost->user->name }}
                                @if($currentPost->user->isAdmin == "admin")
                                    <div class="adminAlert">[ADMIN]</div>

                                @endif
                                <div class="postDate">
                                    {{ $currentPost->created_at }}
                                </div>
                            </div>
                        </div>

                        <div class="postContent">
                            {{ $currentPost->content }}

                            @if($currentPost->postType == "image")
                                <img src="/images/{{ $currentPost->image->fileName }}" alt="Image">
                            @endif

                            <div class="categoryDisplay">
                                Categories:
                                @foreach($currentPost->categories as $currentCategory)
                                    {{ $currentCategory->name }} ,

                                @endforeach
                            </div>


                        </div>

                        <div class="commentsHeader">
                            Comments:

                            <a href=" {{ route("post.index",["id" => $currentPost->id]) }}">
                                <button class="commentsAndDeleteButton"> Comment </button>
                            </a>
                        </div>

                        @foreach($currentPost->comments as $currentComment)
                            <div class="commentContainer">
                                <div>
                                    {{ $currentComment->user->name }} - {{ $currentComment->created_at }}
                                    @if($currentComment->user->isAdmin == "admin")
                                        - [ADMIN]
                                    @endif
                                </div>
                                <div class="commentBox"> {{ $currentComment->content }} </div>
                                @if($currentComment->user_id == $currentLoggedIn->id)
                                    <div class="commentAdmin">
                                        <div class="commentAdminEdit">
                                            <form method="post" action="{{ route("comment.edit") }}">
                                                {{ csrf_field() }}
                                                <input name="commentId" type="hidden" value={{ $currentComment->id }}>
                                                <button> Edit Comment </button>
                                                <input name="newComment" id="newComment" placeholder="{{ $currentComment->content }}">
                                            </form>
                                        </div>

                                        <div class="commentAdminDelete">
                                            <form method="post" action="{{ route("comment.delete") }}">
                                                {{ csrf_field() }}
                                                <input name="commentId" type="hidden" value={{ $currentComment->id }}>
                                                <button type="submit"> Delete Comment</button>
                                            </form>
                                        </div>

                                    </div>
                                @endif
                            </div>

                        @endforeach


                            @if($currentPost->user_id == $currentLoggedIn->id)
                                <div class="userAdmin" id="userAdmin">
                                    <button class="editToggle" onclick="toggle({{ $currentPost->id }})">Edit Post</button>
                                    <div id="{{ $currentPost->id }}editId" class="userAdminEdit">
                                        <form method="post" action="{{ route("post.edit") }}">
                                            {{ csrf_field() }}
                                            <input name="postId" type="hidden" value={{ $currentPost->id }}>
                                            <input name="newPost" id="newPost" placeholder="{{ $currentPost->content }}">
                                            <div class="categoryContainer">
                                                @foreach($categories as $currentCategory)
                                                    <input type="checkbox" value="{{ $currentCategory->id }}" id="{{ $currentCategory->id }}" name="editCategories[]"> {{ $currentCategory->name }}
                                                @endforeach
                                            </div>
                                            <button type="submit"> Edit Post </button>
                                        </form>
                                    </div>

                                    <div id="{{ $currentPost->id }}deleteId" class="userAdminDelete">
                                        <form method="post" action="{{ route("post.delete") }}">
                                            {{ csrf_field() }}
                                            <input name="postId" type="hidden" value={{ $currentPost->id }}>
                                            <button type="submit"> Delete Post </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                    </div>
                @endforeach

                {{ $allPosts->links() }}


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <div id="root">


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggle($thisId) {
        var toCheckEditId = $thisId.toString()+"editId";
        var toCheckDeleteId = $thisId.toString()+"deleteId";

        if (document.getElementById(toCheckEditId).style.display === "none") {
            document.getElementById(toCheckEditId).style.display = "block";
            document.getElementById(toCheckDeleteId).style.display = "block";
        } else {
            document.getElementById(toCheckEditId).style.display = "none";
            document.getElementById(toCheckDeleteId).style.display = "none";
        }
    }
</script>

@endsection


