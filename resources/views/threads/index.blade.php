@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                {{--<div class="page-header">--}}
                {{--<h1>Threads</h1>--}}
                {{--</div>--}}
                @include ('threads._list')

            </div>

            <div class="col-md-4">
                @if (count($trending))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Trending Threads
                        </div>

                        {{--<div class="panel-body">--}}
                        {{--</div>--}}

                        <ul class="list-group">
                            @foreach ($trending as $thread)
                                <li class="list-group-item">
                                    <a href="{{ url($thread->path) }}">
                                        {{ $thread->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                @endif
            </div>

        </div>
    </div>
@endsection
