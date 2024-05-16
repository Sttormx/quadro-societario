<?php

namespace App\Shared\Core;

use App\Shared\Enums\StandardError;
use Exception;

class Result {
    public $isSuccess;
    public $isFailure;
    private $error;
    private $value;

    public function __construct($isSuccess, $error = null, $value = null) {
        if ($isSuccess && $error) {
            throw new Exception(StandardError::INVALID_RESULT->value);
        }
        if (!$isSuccess && $error === null) {
            throw new Exception(StandardError::INVALID_FAILING->value);
        }

        $this->isSuccess = $isSuccess;
        $this->isFailure = !$isSuccess;
        $this->error = $error;
        $this->value = $value;
    }

    public function getValue() {
        if (!$this->isSuccess) {
            throw new Exception(StandardError::CANT_GET_VALUE->value);
        }
        return $this->value;
    }

    public function getErrorValue() {
        return $this->error;
    }

    public function isFailure() {
        return $this->isFailure;
    }

    public static function ok($value = null) {
        return new Result(true, null, $value);
    }

    public static function fail($error) {
        return new Result(false, $error);
    }

    public static function combine($results) {
        foreach ($results as $result) {
            if ($result->isFailure) {
                return $result;
            }
        }
        return self::ok();
    }
}
