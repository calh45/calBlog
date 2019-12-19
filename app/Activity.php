<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * Complete one-to-one relationship with Post
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Post() {
        return $this->belongsTo("App\Post", "post_id", "id");
    }

    /**
     * Complete one-to-one relationship with Comment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Comment() {
        return $this->belongsTo("App\Comment", "post_id", "id");
    }
}
