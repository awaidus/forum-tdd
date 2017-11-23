<?php

namespace App;

use App\Filters\ThreadFilters;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

class Thread extends Model
{
    use RecordsActivity;

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

            //this is not working on 'model deleting event' bcz its generate simple sql query
            //$thread->replies()->delete();
            //Instead we call model itself to fire an event of deleting

            $thread->replies->each(function ($reply) {
                $reply->delete();
            });
            // This '$thread->replies->each->delete()' is equivalent of above

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
        return $this->replies()->create($reply);
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
