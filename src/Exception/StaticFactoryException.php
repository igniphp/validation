<?php declare(strict_types=1);

namespace Igni\Validation\Exception;

use RuntimeException;

class StaticFactoryException extends RuntimeException
{
    public static function forMissingRulesNamespace(): self
    {
        return new self("Missing constant RULES_NAMESPACE");
    }
}
