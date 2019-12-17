<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function Post() {
        return $this->belongsTo("App\Post", "post_id", "id");
    }

    public function Comment() {
        return $this->belongsTo("App\Comment", "post_id", "id");
    }
}
