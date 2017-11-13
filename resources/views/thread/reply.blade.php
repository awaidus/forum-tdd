<div class="panel panel-default">
    <div class="panel-heading">
        <a href="#">{{$reply->user->name}}</a> said {{$reply->created_at->diffForhumans()}}
    </div>
    <div class="panel-body">
        <div class="body">{{$reply->body}}</div>
    </div>
</div>