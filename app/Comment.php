<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        "content"
    ];

    /**
     * A Comment can only have one corresponding User author. Completes one-to-many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo("App\User", "user_id", "id");
    }

    /**
     * A Comment can only be posted on one Post. Completes one-to-many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post() {
        return $this->belongsTo("App\Post", "post_id", "id");
    }

    public function activity() {
        return $this->hasOne("App\Activity", "post_id", "id");
    }

}
