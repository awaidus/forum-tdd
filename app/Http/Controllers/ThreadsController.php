<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Rules\SpamFree;
use App\Thread;
use App\Trending;
use Illuminate\Http\Request;


class ThreadsController extends Controller
{

    /**
     * Create a new ThreadsController instance
     */
    public function __construct()
    {
        $this->middleware('auth')->except([ 'index', 'show' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads'  => $threads,
            'trending' => null,//$trending->get(),
        ]);
    }

    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(25);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created Thread .
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @internal param Spam $spam
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      => [ 'required', new SpamFree ],
            'body'       => [ 'required', new SpamFree ],
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body'),
            'slug'       => request('title'),
        ]);

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published!');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Channel $channel
     * @param  \App\Thread $thread
     * @param Trending $trending
     * @return Thread
     * @internal param $channelId
     */
    public function show($channel, Thread $thread)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        //$trending->push($thread);

        $thread->increment('visits');

        return view('threads.show', compact('thread'));
    }

    /**
     * @param \App\Channel $channel
     * @param Thread $thread
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        //Related replies will be deleted at 'deleting model event' of Thread Model
        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }
}
