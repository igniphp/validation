<?php declare(strict_types=1);

namespace Igni\Validation;

use Igni\Validation\Exception\BadMethodCallException;

/**
 * Magic static factory method for convenient Rule instantiation.
 */
trait StaticRuleFactory
{
    public static function __callStatic($name, $arguments): Assertion
    {
        $ruleClass = '\\Igni\\Validation\\Assertion\\' . ucfirst($name);
        if (!class_exists($ruleClass)) {
            throw new BadMethodCallException("Validator (${name}) does not exists.");
        }

        return new $ruleClass(...$arguments);
    }
}
