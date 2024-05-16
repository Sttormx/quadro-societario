<?php

namespace App\Shared\Core;

class Right extends Either {
    public $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function isLeft() {
        return false;
    }

    public function isRight() {
        return true;
    }
}