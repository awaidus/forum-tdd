@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->user) }}">{{ $thread->user->name }}</a>
                                posted: {{ $thread->title }}
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
                        <div class="body">{{$thread->body}}</div>
                    </div>
                </div>
                @foreach ($replies as $reply)
                    @include('thread.reply')
                @endforeach

                {{ $replies->links() }}

            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->user->name }}</a>, and currently
                            has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}
                            .
                        </p>
                    </div>
                </div>
            </div>


        </div>


        @if(auth()->check())
            <div class="row">
                <div class="col-md-8">
                    <form method="post" action="{{$thread->path().'/replies'}}">
                        {{csrf_field()}}

                        <div class="form-group">
                        <textarea name="body" id="body" rows="5" class="form-control"
                                  placeholder="Say something"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center">Please <a href="{{route('login')}}">Sign-In</a> to submit reply </p>
        @endif


    </div>
@endsection
