<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

class Thread extends Model
{
    protected $guarded = [];

    /**
     * Thread will always have these eager loading
     */
    protected $with = ['user', 'channel'];

    /**
     * Boot the model,
     * Eager loading each
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        /** Deleting related replies when thread delete request is processed */
        static::deleting(function ($thread) {
            $thread->replies()->delete();
        });

    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param Builder $query
     * @param ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
