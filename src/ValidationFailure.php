<?php declare(strict_types=1);

namespace Igni\Validation;

use Igni\Validation\Failures\EmptyValueFailure;
use Igni\Validation\Failures\InvalidLengthFailure;
use Igni\Validation\Failures\OutOfRangeFailure;
use Igni\Validation\Failures\ValueTooHigh;
use Igni\Validation\Failures\ValueTooLong;
use Igni\Validation\Failures\ValueTooLow;
use Igni\Validation\Failures\ValueTooShort;

class ValidationFailure
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

    public static function forEmptyValue(Rule $context, string $message = null): EmptyValueFailure
    {
        return new class($context, $message) extends ValidationFailure implements EmptyValueFailure { };
    }

    public static function forAssertionFailure(Rule $context, string $message = null): EmptyValueFailure
    {
        return new class($context, $message) extends ValidationFailure implements EmptyValueFailure { };
    }

    public static function forInvalidLength(Rule $context, string $message = null): InvalidLengthFailure
    {
        return new class($context, $message) extends ValidationFailure implements InvalidLengthFailure { };
    }

    public static function forValueTooShort(Rule $context, string $message = null): ValueTooShort
    {
        return new class($context, $message) extends ValidationFailure implements InvalidLengthFailure, ValueTooShort { };
    }

    public static function forValueTooLong(Rule $context, string $message = null): ValueTooLong
    {
        return new class($context, $message) extends ValidationFailure implements InvalidLengthFailure, ValueTooLong { };
    }

    public static function forOutOfRange(Rule $context, string $message = null): OutOfRangeFailure
    {
        return new class($context, $message) extends ValidationFailure implements OutOfRangeFailure { };
    }

    public static function forValueTooHigh(Rule $context, string $message = null): ValueTooHigh
    {
        return new class($context, $message) extends ValidationFailure implements OutOfRangeFailure, ValueTooHigh { };
    }

    public static function forValueTooLow(Rule $context, string $message = null): ValueTooLow
    {
        return new class($context, $message) extends ValidationFailure implements OutOfRangeFailure, ValueTooLow { };
    }
}
