<?php

namespace App\Shared\Enums;

enum StandardError: string
{
    case INVALID_RESULT = 'InvalidOperation: A result cannot be successful and contain an error';
    case INVALID_FAILING = 'InvalidOperation: A failing result needs to contain an error message';
    case CANT_GET_VALUE = "Can't get the value of an error result. Use 'getErrorValue' instead.";
}
