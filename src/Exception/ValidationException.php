<?php declare(strict_types=1);

namespace Igni\Validation\Exception;

use RuntimeException;
use Igni\Validation\Message\DefaultMessageFactory;
use Igni\Validation\Message\MessageFactory;
use Igni\Validation\Rule;
use Igni\Validation\ValidationError;

class ValidationException extends RuntimeException
{
    private static $messageFactory;

    public static function forInvalidLengthSet(): self
    {
        return new self('Allowed $max length cannot be lower than $min length.');
    }

    public static function forInvalidRangeSet(): self
    {
        return new self('Allowed $max value cannot be lower than $min value.');
    }

    public static function forInvalidRule($rule): self
    {
        $class = get_class($rule);
        return new self("Rule (${class}) is not valid instance of " . Rule::class);
    }

    public static function forValidationFailure(ValidationError $failure, MessageFactory $messageFactory = null): ValidationException
    {
        if (!$messageFactory) {
            $messageFactory = self::getMessageFactory();
        }
        return new self((string) $messageFactory->create($failure));
    }

    private static function getMessageFactory(): MessageFactory
    {
        if (self::$messageFactory) {
            return self::$messageFactory;
        }

        return self::$messageFactory = new DefaultMessageFactory();
    }
}
