<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * A Comment can only have one corresponding User author. Completes one-to-many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo("App\User", "userId", "id");
    }

    /**
     * A Comment can only be posted on one Post. Completes one-to-many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post() {
        return $this->belongsTo("App\Post", "postId", "id");
    }

}
