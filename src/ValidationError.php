<?php declare(strict_types=1);

namespace Igni\Validation;

use Igni\Validation\Error\EmptyValueError;
use Igni\Validation\Error\InvalidLengthError;
use Igni\Validation\Error\OutOfRangeError;
use Igni\Validation\Error\ValueTooHigh;
use Igni\Validation\Error\ValueTooLong;
use Igni\Validation\Error\ValueTooLow;
use Igni\Validation\Error\ValueTooShort;
use Igni\Validation\Exception\InvalidArgumentException;
use Igni\Validation\Message\DefaultMessageFactory;
use Igni\Validation\Message\MessageFactory;

class ValidationError
{
    /**
     * @var MessageFactory
     */
    private static $messageFactory;

    /**
     * @var string
     */
    private $message;

    /**
     * @var Assertion
     */
    private $context;

    public function __construct(Assertion $context, string $message = null)
    {
        $this->message = $message;
        $this->context = $context;
    }

    public function getContext(): Assertion
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

    public static function forEmptyValue(Assertion $context, string $message = null): EmptyValueError
    {
        return new class($context, $message) extends ValidationError implements EmptyValueError { };
    }

    public static function forAssertionFailure(Assertion $context, string $message = null): EmptyValueError
    {
        return new class($context, $message) extends ValidationError implements EmptyValueError { };
    }

    public static function forInvalidLength(Assertion $context, string $message = null): InvalidLengthError
    {
        return new class($context, $message) extends ValidationError implements InvalidLengthError { };
    }

    public static function forValueTooShort(Assertion $context, string $message = null): ValueTooShort
    {
        return new class($context, $message) extends ValidationError implements InvalidLengthError, ValueTooShort { };
    }

    public static function forValueTooLong(Assertion $context, string $message = null): ValueTooLong
    {
        return new class($context, $message) extends ValidationError implements InvalidLengthError, ValueTooLong { };
    }

    public static function forOutOfRange(Assertion $context, string $message = null): OutOfRangeError
    {
        return new class($context, $message) extends ValidationError implements OutOfRangeError { };
    }

    public static function forValueTooHigh(Assertion $context, string $message = null): ValueTooHigh
    {
        return new class($context, $message) extends ValidationError implements OutOfRangeError, ValueTooHigh { };
    }

    public static function forValueTooLow(Assertion $context, string $message = null): ValueTooLow
    {
        return new class($context, $message) extends ValidationError implements OutOfRangeError, ValueTooLow { };
    }

    public function toException(): InvalidArgumentException
    {
        $message = static::getMessageFactory()->create($this);
        return new class($message->getMessage()) extends InvalidArgumentException {};
    }

    private static function getMessageFactory(): MessageFactory
    {
        if (self::$messageFactory) {
            return self::$messageFactory;
        }

        return self::$messageFactory = new DefaultMessageFactory();
    }
}
