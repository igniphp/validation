<?php declare(strict_types=1);

namespace Igni\Validation\Message;

use Igni\Validation\Error\EmptyValueError;
use Igni\Validation\Error\InvalidLengthError;
use Igni\Validation\Error\OutOfRangeError;
use Igni\Validation\Error\ValueTooHigh;
use Igni\Validation\Error\ValueTooLong;
use Igni\Validation\Error\ValueTooLow;
use Igni\Validation\Error\ValueTooShort;
use Igni\Validation\Message;
use Igni\Validation\ValidationError;
use Igni\Validation\Rules;

final class DefaultMessageFactory implements MessageFactory
{
    private const OUT_OF_RANGE = '${name} is out of range - must be between ${min} and ${max}.';
    private const TOO_LOW = '${name} is out of range - must be higher or equal to ${min}.';
    private const TOO_HIGH = '${name} is out of range - must be lower or equal to ${max}.';
    private const INVALID_LENGTH = '${name} has invalid length - must be between ${min} and ${max}.';
    private const TOO_SHORT = '${name} has invalid length - must be longer or equal to ${min}.';
    private const TOO_LONG = '${name} has invalid length - must be shorter or equal to ${max}.';
    private const REQUIRED = '${name} is required.';

    private const DEFAULT_ASSERTION = '${name} is not valid.';

    private const INVALID_ALNUM = '${name} is not a valid alphanumeric string.';
    private const INVALID_ALPHA = '${name} is not a valid alphabetic sequence.';
    private const INVALID_BOOLEAN = '${name} is not a valid boolean value.';
    private const INVALID_CONTAINS = '${name} does not contain expected value (${contains})';
    private const INVALID_DATE = '${name} is not a valid boolean value.';
    private const INVALID_EMAIL = '${name} is not a valid email.';
    private const INVALID_FALSY = '${name} is not a valid falsy expression.';
    private const INVALID_IN = '${name} is not in ${valid_values}.';
    private const INVALID_INTEGER = '${name} is not a valid integer.';
    private const INVALID_NUMBER = '${name} is not a valid number.';
    private const INVALID_REGEX = '${name} does not match pattern (${pattern}).';
    private const INVALID_TEXT = '${name} is not a valid text.';
    private const INVALID_TRUTHY = '${name} is not a valid truthy expression.';
    private const INVALID_UUID = '${name} is not a valid uuid expression.';

    private static $defaultMap = [
        'default' => self::DEFAULT_ASSERTION,
        Rules\Alnum::class => self::INVALID_ALNUM,
        Rules\Alpha::class => self::INVALID_ALPHA,
        Rules\Boolean::class => self::INVALID_BOOLEAN,
        Rules\Contains::class => self::INVALID_CONTAINS,
        Rules\Date::class => self::INVALID_DATE,
        Rules\Email::class => self::INVALID_EMAIL,
        Rules\Falsy::class => self::INVALID_FALSY,
        Rules\In::class => self::INVALID_IN,
        Rules\Integer::class => self::INVALID_INTEGER,
        Rules\Number::class => self::INVALID_NUMBER,
        Rules\Regex::class => self::INVALID_REGEX,
        Rules\Text::class => self::INVALID_TEXT,
        Rules\Truthy::class => self::INVALID_TRUTHY,
        Rules\Uuid::class => self::INVALID_UUID,
    ];

    private $map;

    public function __construct(array $map = [])
    {
        $this->map = self::$defaultMap + $map;
    }

    public function create(ValidationError $error): Message
    {
        switch (true) {
            case $error instanceof ValueTooHigh:
                return new Message(self::TOO_HIGH, $error->getContext());

            case $error instanceof ValueTooLow:
                return new Message(self::TOO_LOW, $error->getContext());

            case $error instanceof ValueTooLong:
                return new Message(self::TOO_LONG, $error->getContext());

            case $error instanceof ValueTooShort:
                return new Message(self::TOO_SHORT, $error->getContext());

            case $error instanceof InvalidLengthError:
                return new Message(self::INVALID_LENGTH, $error->getContext());

            case $error instanceof OutOfRangeError:
                return new Message(self::OUT_OF_RANGE, $error->getContext());

            case $error instanceof EmptyValueError:
                return new Message(self::REQUIRED, $error->getContext());

            default:
                return $this->factoryForAssertionFailure($error);
        }
    }

    private function factoryForAssertionFailure(ValidationError $failure): Message
    {
        $context = $failure->getContext();

        if ($failure->hasMessage()) {
            return new Message($failure->getMessage(), $context);
        }

        $ruleClass = get_class($context);

        if (isset($this->map[$ruleClass])) {
            return new Message($this->map[$ruleClass], $context);
        }

        return new Message($this->map['default'], $context);
    }

    public function setMessageForAssertion(string $assertionClass, string $message)
    {
        $this->map[$assertionClass] = $message;
    }
}
