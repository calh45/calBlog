<link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
@extends('layouts.app')

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            CalBlog
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <p class="dropdown-item">Profile</p>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="postContainer">
                        <div class="postHeader">
                            <div class="postName">
                                {{ $postToReturn->user->name }}
                                <div class="postDate">
                                    {{ $postToReturn->created_at }}
                                </div>
                            </div>
                        </div>
                        {{ $postToReturn->content }}

                        @if($postToReturn->postType == "image")
                            <img src="/images/{{ $postToReturn->image->fileName }}" alt="Image">
                        @endif

                        <div>Comments: </div>
                        <div id="root">
                            <div v-for="comment in comments">
                                @{{ comment.user_id }} - @{{ comment.created_at }}
                                <div class="commentBox"> @{{ comment.content }} </div>
                            </div>

                            <input v-model="content" class="commentBox" id="input" type="text" placeholder="Write a comment...">
                            <button @click="createComment"> Comment </button>
                        </div>





                    </div>


                    </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>

        var app = new Vue ({
            el: "#root",
            data: {
                comments: [],
                content: '',
            },
            mounted() {
                axios.get("{{ route('api.comments.index', ["postId" => $postToReturn->id]) }}").then(response => {
                    this.comments = response.data;
                }).catch(response => {
                    console.log(response);
                })
            },
            methods: {
                createComment: function () {
                    axios.post("{{ route('api.comments.create', ["postId" => $postToReturn->id, "userId" => $postToReturn->user_id]) }}", {
                        name: this.content
                    }).then(response => {
                        this.comments.push(response.data);
                        this.content = '';
                    }).catch(response => {
                        console.log(response);
                    })
                }
            },

        });


    </script>

