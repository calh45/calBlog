<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        "content"
    ];
    /**
     * A Post can only have been created by one user. Completes one-to-many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo("App\User", "user_id", "id");
    }

    /**
     * A post can have many different comments, leading to one-to-many relationship.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany("App\Comment", "post_id", "id");
    }

    /**
     * Complete one-to-one relationship with Image model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image() {
        return $this->belongsTo("App\Image", "image_id", "id");
    }

    /**
     * Create one-to-one relationship with Activity model
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activity() {
        return $this->hasOne("App\Activity", "post_id", "id");
    }

    /**
     * Complete many-to-many relationship with Category model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() {
        return $this->belongsToMany("App\Category", "category_post", "post_id", "category_id");
    }
}
