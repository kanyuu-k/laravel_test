@extends('layouts.app')
@section('content')

@if(session('message'))
<div class="alert alert-success">{{session('message')}}</div>
@endif

<div class="ml-2 mb-3">
    あなたのコメントした投稿一覧
</div>

@if (count($comments) == 0)
<p>
あなたはまだコメントしていません。
</p>
@else
@foreach ($comments->unique('post_id') as $comment)
@php
    //コメントした投稿
    $post = $comment->post;
@endphp
<div class="container-fluid mt-20" style="margin-left:-10px;">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="media flex-wrap w-100 align-items-center">
                        <img src="{{asset('storage/avatar/'.($post->user->avatar??'user_default.jpg'))}}"
                        class="rounded-circle" style="width:40px;height:40px;">                        <div class="media-body ml-3"><a href="{{route('post.show', $post)}}">{{$post->title}}</a> 
                            <div class="text-muted small">{{$post->user->name??'削除されたユーザー'}}</div>
                        </div>
                        <div class="text-muted small ml-3">
                            <div>投稿日</div>
                            <div><strong>{{$post->created_at->diffForHumans()}}</strong></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>{{Str::limit($post->body, 50, ' ...')}}</p>
                </div>
                <div class="card-footer d-flex flex-wrap justify-content-between align-items-center px-0 pt-0 pb-3">
                    <div class="px-4 pt-3">
                        @if ($post->comments->count())
                        <span class="badge badge-success">
                            コメント {{$post->comments->count()}}件
                        </span>
                    @else
                        <span>コメントはありません。</span>
                    @endif
                    </div>

                    <div class="px-4 pt-3"> 
                       <button type="button" class="btn btn-primary">
                          <a href="{{route('post.show', $post)}}" style="color:white;">コメントする</a>
                      </button> </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
@endsection