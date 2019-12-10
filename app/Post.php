<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * A Post can only have been created by one user. Completes one-to-many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo("App\User", "userId", "id");
    }

    /**
     * A post can have many different comments, leading to one-to-many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany("App\Comment", "postId", "id");
    }

    public function image() {
        return $this->belongsTo("App\Image", "image_id", "id");
    }
}
