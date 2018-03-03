<?php declare(strict_types=1);

namespace Igni\Validation\Message;

use Igni\Validation\Failures\EmptyValueFailure;
use Igni\Validation\Failures\InvalidLengthFailure;
use Igni\Validation\Failures\OutOfRangeFailure;
use Igni\Validation\Failures\ValueTooHigh;
use Igni\Validation\Failures\ValueTooLong;
use Igni\Validation\Failures\ValueTooLow;
use Igni\Validation\Failures\ValueTooShort;
use Igni\Validation\Message;
use Igni\Validation\ValidationFailure;
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

    public function create(ValidationFailure $failure): Message
    {
        switch (true) {
            case $failure instanceof ValueTooHigh:
                return new Message(self::TOO_HIGH, $failure->getContext());

            case $failure instanceof ValueTooLow:
                return new Message(self::TOO_LOW, $failure->getContext());

            case $failure instanceof ValueTooLong:
                return new Message(self::TOO_LONG, $failure->getContext());

            case $failure instanceof ValueTooShort:
                return new Message(self::TOO_SHORT, $failure->getContext());

            case $failure instanceof InvalidLengthFailure:
                return new Message(self::INVALID_LENGTH, $failure->getContext());

            case $failure instanceof OutOfRangeFailure:
                return new Message(self::OUT_OF_RANGE, $failure->getContext());

            case $failure instanceof EmptyValueFailure:
                return new Message(self::REQUIRED, $failure->getContext());

            default:
                return $this->factoryForAssertionFailure($failure);
        }
    }

    private function factoryForAssertionFailure(ValidationFailure $failure): Message
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
