@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{$thread->user->name}}</a> posted
                        {{$thread->title}}
                    </div>
                    <div class="panel-body">
                        <div class="body">{{$thread->body}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('thread.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
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
