@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.min.css">
@endsection

@section('content')

    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <img src="{{ $thread->user->avatar_path }}"
                                     alt="{{ $thread->user->name }}"
                                     width="25"
                                     height="25"
                                     class="mr-1">

                                <span class="flex">
                                    <a href="{{ route('profile', $thread->user) }}">{{ $thread->user->name }}</a> posted:
                                    {{ $thread->title }}
                                </span>

                                @can ('update', $thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="panel-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>

                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->user->name }}</a>, and currently has
                                <span v-text="repliesCount"></span>
                                {{ str_plural('comment', $thread->replies_count) }}
                                .
                            </p>

                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection