<?php declare(strict_types=1);

namespace Igni\Validation\Message;

use Igni\Validation\Assertion;
use Igni\Validation\Error\EmptyValueError;
use Igni\Validation\Error\InvalidLengthError;
use Igni\Validation\Error\OutOfRangeError;
use Igni\Validation\Error\ValueTooHigh;
use Igni\Validation\Error\ValueTooLong;
use Igni\Validation\Error\ValueTooLow;
use Igni\Validation\Error\ValueTooShort;
use Igni\Validation\ValidationError;

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
    private const INVALID_IP = '${name} is not a valid ip address.';
    private const INVALID_IPV4 = '${name} is not a valid ip v4 address.';
    private const INVALID_IPV6 = '${name} is not a valid ip v6 address.';
    private const INVALID_NUMBER = '${name} is not a valid number.';
    private const INVALID_REGEX = '${name} does not match pattern (${pattern}).';
    private const INVALID_TEXT = '${name} is not a valid text.';
    private const INVALID_TRUTHY = '${name} is not a valid truthy expression.';
    private const INVALID_URI = '${name} is not a valid uri.';
    private const INVALID_URL = '${name} is not a valid url.';
    private const INVALID_UUID = '${name} is not a valid uuid expression.';

    private static $defaultMap = [
        'default' => self::DEFAULT_ASSERTION,
        Assertion\Alnum::class => self::INVALID_ALNUM,
        Assertion\Alpha::class => self::INVALID_ALPHA,
        Assertion\Boolean::class => self::INVALID_BOOLEAN,
        Assertion\Contains::class => self::INVALID_CONTAINS,
        Assertion\Date::class => self::INVALID_DATE,
        Assertion\Email::class => self::INVALID_EMAIL,
        Assertion\Falsy::class => self::INVALID_FALSY,
        Assertion\In::class => self::INVALID_IN,
        Assertion\Integer::class => self::INVALID_INTEGER,
        Assertion\Ip::class => self::INVALID_IP,
        Assertion\Ipv4::class => self::INVALID_IPV4,
        Assertion\Ipv6::class => self::INVALID_IPV6,
        Assertion\Number::class => self::INVALID_NUMBER,
        Assertion\Regex::class => self::INVALID_REGEX,
        Assertion\Text::class => self::INVALID_TEXT,
        Assertion\Truthy::class => self::INVALID_TRUTHY,
        Assertion\Uri::class => self::INVALID_URI,
        Assertion\Url::class => self::INVALID_URL,
        Assertion\Uuid::class => self::INVALID_UUID,
    ];

    private const INTERPOLATION_PATTERN = '${%s}';

    private $map;

    public function __construct(array $map = [])
    {
        $this->map = self::$defaultMap + $map;
    }

    public function create(ValidationError $error): string
    {
        switch (true) {
            case $error instanceof ValueTooHigh:
                $template = self::TOO_HIGH;
                break;

            case $error instanceof ValueTooLow:
                $template = self::TOO_LOW;
                break;

            case $error instanceof ValueTooLong:
                $template = self::TOO_LONG;
                break;

            case $error instanceof ValueTooShort:
                $template = self::TOO_SHORT;
                break;

            case $error instanceof InvalidLengthError:
                $template = self::INVALID_LENGTH;
                break;

            case $error instanceof OutOfRangeError:
                $template = self::OUT_OF_RANGE;
                break;

            case $error instanceof EmptyValueError:
                $template = self::REQUIRED;
                break;

            default:
                return $this->factoryForAssertionFailure($error);
        }

        return $this->interpolateString($template, $error->getContext());
    }

    private function factoryForAssertionFailure(ValidationError $error): string
    {
        $context = $error->getContext();

        if ($error->hasMessage()) {
            return $this->interpolateString($error->getMessage(), $context);
        }

        $ruleClass = get_class($context);

        if (isset($this->map[$ruleClass])) {
            return $this->interpolateString($this->map[$ruleClass], $context);
        }

        return $this->interpolateString($this->map['default'], $context);
    }

    private function interpolateString(string $message, Assertion $assertion): string
    {
        $params = [];
        foreach($assertion->getAttributes() as $name => $value)
        {
            $params[sprintf(self::INTERPOLATION_PATTERN, $name)] = $value;
        }

        return strtr($message, $params);
    }
}
