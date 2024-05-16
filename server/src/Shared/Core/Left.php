<?php

namespace App\Shared\Core;

class Left extends Either {
    public $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function isLeft() {
        return true;
    }

    public function isRight() {
        return false;
    }
}