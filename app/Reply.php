<?php

namespace App;

use App\Traits\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;

    protected $guarded = [];

    //Reply will always return with these eager loading
    protected $with = ['user', 'favorites'];

    /**
     * Onwer of the reply
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
