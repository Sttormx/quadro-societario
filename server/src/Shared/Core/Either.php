<?php

namespace App\Shared\Core;

abstract class Either {
    public $value;
    abstract public function isLeft();
    abstract public function isRight();
}
