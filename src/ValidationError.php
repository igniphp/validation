<?php declare(strict_types=1);

namespace Igni\Validation;

use Igni\Validation\Error\EmptyValueError;
use Igni\Validation\Error\InvalidLengthError;
use Igni\Validation\Error\OutOfRangeError;
use Igni\Validation\Error\ValueTooHigh;
use Igni\Validation\Error\ValueTooLong;
use Igni\Validation\Error\ValueTooLow;
use Igni\Validation\Error\ValueTooShort;

class ValidationError
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var Rule
     */
    private $context;

    public function __construct(Rule $context, string $message = null)
    {
        $this->message = $message;
        $this->context = $context;
    }

    public function getContext(): Rule
    {
        return $this->context;
    }

    public function hasMessage(): bool
    {
        return $this->message !== null;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public static function forEmptyValue(Rule $context, string $message = null): EmptyValueError
    {
        return new class($context, $message) extends ValidationError implements EmptyValueError { };
    }

    public static function forAssertionFailure(Rule $context, string $message = null): EmptyValueError
    {
        return new class($context, $message) extends ValidationError implements EmptyValueError { };
    }

    public static function forInvalidLength(Rule $context, string $message = null): InvalidLengthError
    {
        return new class($context, $message) extends ValidationError implements InvalidLengthError { };
    }

    public static function forValueTooShort(Rule $context, string $message = null): ValueTooShort
    {
        return new class($context, $message) extends ValidationError implements InvalidLengthError, ValueTooShort { };
    }

    public static function forValueTooLong(Rule $context, string $message = null): ValueTooLong
    {
        return new class($context, $message) extends ValidationError implements InvalidLengthError, ValueTooLong { };
    }

    public static function forOutOfRange(Rule $context, string $message = null): OutOfRangeError
    {
        return new class($context, $message) extends ValidationError implements OutOfRangeError { };
    }

    public static function forValueTooHigh(Rule $context, string $message = null): ValueTooHigh
    {
        return new class($context, $message) extends ValidationError implements OutOfRangeError, ValueTooHigh { };
    }

    public static function forValueTooLow(Rule $context, string $message = null): ValueTooLow
    {
        return new class($context, $message) extends ValidationError implements OutOfRangeError, ValueTooLow { };
    }
}
