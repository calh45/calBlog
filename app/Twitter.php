<?php

namespace App;

class Twitter {

    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
}
