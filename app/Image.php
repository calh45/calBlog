<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function post() {
        return $this->hasOne("App\Post", "image_id", "id");
    }
}
