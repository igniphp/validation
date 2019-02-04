<?php declare(strict_types=1);

namespace Igni\Validation;

use BadMethodCallException;
use Igni\Validation\Exception\StaticFactoryException;

/**
 * Magic static factory method for convenient Rule instantiation.
 */
trait StaticRuleFactory
{
    public static function __callStatic($name, $arguments): Rule
    {
        if (self::RULES_NAMESPACE === null) {
            throw StaticFactoryException::forMissingRulesNamespace();
        }

        $ruleClass = self::RULES_NAMESPACE . ucfirst($name);
        if (!class_exists($ruleClass)) {
            throw new BadMethodCallException("Validator (${name}) does not exists.");
        }

        return new $ruleClass(...$arguments);
    }
}
