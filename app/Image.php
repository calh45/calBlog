<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Create one-to-one relationship with Post
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function post() {
        return $this->hasOne("App\Post", "image_id", "id");
    }
}
