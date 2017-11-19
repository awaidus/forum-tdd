@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">Forum Threads</div>

                        <div class="panel-body">
                            <h4>
                                <a href="{{$thread->path()}}">{{$thread->title}}</a>
                            </h4>
                            <div class="body">{{$thread->body}}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
