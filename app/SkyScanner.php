<?php

namespace App;

class SkyScanner {

    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
}
