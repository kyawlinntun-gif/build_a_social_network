@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="dashboard">

        <div class="container mt-5">

            @include('messages/info/success')
            @include('messages.info.error')

            <div class="row">
    
                <div class="col-6 offset-3">
    
                    <div class="new-post">
    
                        <h3>What do you have to say?</h3>
                        {{ Form::open(['route' => 'post.store', 'method' => 'post']) }}
                            {{ Form::bsTextarea('body', '', ['placeholder' => 'Your Post']) }}
                            @include('messages.errors.body')
                            {{ Form::submit('Create Post', ['class' => 'btn btn-primary']) }}
                        {{ Form::close() }}
                    </div>
    
                </div>
    
                <hr>
    
                <div class="col-6 offset-3">

                    <h3>What other people say...</h3>

                    @foreach ($posts as $post)
                    
                        <section class="mt-5">
                            <p class="post_body" data-postId="{{ $post->id }}">
                                {{ $post->body }}
                            </p>
                            <div class="text-muted font-italic">Posted by {{ $post->user->name }} on {{ $post->created_at->diffForHumans() }}</div>
                            <div>
                                <a href="#" class="like">
                                    @if(Auth::user()->likes()->where('post_id', $post->id)->first())
                                        @if(Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1)
                                            You like this post
                                        @else
                                            Like
                                        @endif
                                    @else
                                        Like
                                    @endif
                                </a> | 
                                <a href="#" class="like">
                                    @if(Auth::user()->likes()->where('post_id', $post->id)->first())
                                        @if(Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0)
                                            You don't like this post
                                        @else
                                            DisLike
                                        @endif
                                    @else
                                        DisLike
                                    @endif
                                </a>
                                @can('delete', $post)
                                     |
                                    <a href="#" class="edit">Edit</a> |
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('delete').submit();">Delete</a>
                                    {{ Form::open(['route' => ['post.destroy', $post->id], 'method' => 'post', 'id' => 'delete']) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                    {{ Form::close() }}
                                @endcan
                            </div>
                        </section>

                    @endforeach
    
                </div>
    
            </div>
    
        </div>

        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" data-id>
                        {{ Form::open(['url' => '/', 'method' => 'get']) }}
                            {{ Form::bsTextarea('body', '', ['id' => 'body1']) }}
                        {{ Form::close() }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="button">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('jQuery')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function(){

            $(".dashboard .edit").on('click', function(e){
                e.preventDefault();
                // var post_body = $("#post_body").html();
                // var post_body = $.trim($("#post_body").text());
                var postId = $(this).parent().parent().children('.post_body').attr('data-postId');
                var post_body = $.trim($(this).parent().parent().children('.post_body').text());
                $(".dashboard .modal .modal-body").attr('data-id', postId);
                $(".dashboard .modal .modal-body #body1").val(post_body);
                $(".dashboard .modal").modal();
                $(".dashboard .modal .modal-body #body1").focus();
                
            });
            $("#button").on('click', function(e) {
                e.preventDefault();
                var token = "{{ Session::token() }}"; 
                // var postId = $("#post_body").attr('data-postId');
                var postId = $(".dashboard .modal .modal-body").attr('data-id');
                var body = $.trim($(".dashboard .modal .modal-body #body1").val());
                // console.log(postId, body);

                $.ajax({
                    type: "POST",
                    url: "{{ route('post.update') }}",
                    data: {body: body, postId: postId}
                })
                .done(function (msg) {
                    var postBody = $('p.post_body[data-postId='+ postId +']');
                    postBody.html(msg['body']);
                    // console.log(postBody);
                    $(".dashboard .modal").modal('hide');
                    // console.log(msg['body']);
                });
            });

            $(".dashboard").on('click', '.like', function(e){
                // var postId = $("#post_body").attr('data-postId');
                var postId = $(this).parent().parent().children('.post_body').attr('data-postId');
                let islike = e.target.previousElementSibling == null;
                let button = $(this, '.like');
                // console.log(button.siblings('.like').text());
                let otherbutton = button.siblings('.like');
                // console.log(postId);
                $.ajax({
                    method: 'POST',
                    url: "{{ route('like') }}",
                    data:{islike: islike, postId: postId}
                }).done(function(data){
                    // console.log(data['data']);
                    if(data['data'])
                    {
                        $.each(data['data'], function(key, check){
                            // console.log(check['like']);
                            if(check['like'] == true)
                            {
                                $(button).html('You like this post');
                                $(otherbutton).html('DisLike');
                            }
                            else if(check['like'] == false)
                            {
                                $(button).html('You don\'t like this post');
                                $(otherbutton).html('Like');
                            }
                        });
                    }
                    else if(data['remove'])
                    {
                        $.each(data['remove'], function(key, remove){
                            if(remove['like'] == true)
                            {
                                $(button).html('Like');
                            }
                            else if(remove['like'] == false)
                            {
                                $(button).html('DisLike');
                            }
                        });
                    }
                });
            });
        })
    </script>

@endsection
