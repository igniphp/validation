<?php declare(strict_types=1);

namespace Igni\Validation;

use Igni\Validation\Exception\BadMethodCallException;

/**
 * Magic static factory method for convenient Rule instantiation.
 *
 * @method static Assertion\Alnum alnum(int $min = null, int $max = null)
 * @method static Assertion\Alpha alpha(int $min = null, int $max = null)
 * @method static Assertion\Boolean boolean(int $min = null, int $max = null)
 * @method static Assertion\Chain chain(Assertion ...$rules)
 * @method static Assertion\Contains contains(string $text)
 * @method static Assertion\Date date(string $format = null, $min = null, $max = null)
 * @method static Assertion\Each each(Validator $validator)
 * @method static Assertion\Email email()
 * @method static Assertion\Falsy falsy()
 * @method static Assertion\Group group(array $definition)
 * @method static Assertion\In in(...$possibleValues)
 * @method static Assertion\Integer integer(int $min = null, int $max = null)
 * @method static Assertion\Ip ip()
 * @method static Assertion\Ipv4 ipv4()
 * @method static Assertion\Ipv6 ipv6()
 * @method static Assertion\Number number(float $min = null, float $max = null)
 * @method static Assertion\Uuid uuid()
 * @method static Assertion\Regex regex(string $regex)
 * @method static Assertion\Text text(int $min = null, int $max = null)
 * @method static Assertion\Truthy truthy()
 * @method static Assertion\Uri uri()
 * @method static Assertion\Url url()
 *
 * @example:
 * Constrain::alnum(2)('test');
 *
 */
trait StaticRuleFactory
{
    public static function __callStatic($name, $arguments): Assertion
    {
        if (!self::isSupported($name)) {
            throw new BadMethodCallException("Validator (${name}) does not exists.");
        }

        $assertionClass = '\\Igni\\Validation\\Assertion\\' . ucfirst($name);
        return new $assertionClass(...$arguments);
    }

    public static function isSupported($name): bool
    {
        $ruleClass = '\\Igni\\Validation\\Assertion\\' . ucfirst($name);
        return class_exists($ruleClass);
    }
}
