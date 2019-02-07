<?php declare(strict_types=1);

namespace Igni\Validation\Exception;

use Igni\Validation\Assertion;

class InvalidArgumentException extends \InvalidArgumentException implements ValidationException
{
    public static function forInvalidLengthSet(): self
    {
        return new self('Allowed $max length cannot be lower than $min length.');
    }

    public static function forInvalidRangeSet(): self
    {
        return new self('Allowed $max value cannot be lower than $min value.');
    }

    public static function forInvalidAssertion($assertion): self
    {
        $class = get_class($assertion);
        return new self("Rule (${class}) is not valid instance of " . Assertion::class);
    }
}
