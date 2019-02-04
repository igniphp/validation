<?php declare(strict_types=1);

namespace Igni\Validation;

use Igni\Validation\Rules\LengthRule;
use Igni\Validation\Rules\RangeRule;
use BadMethodCallException;

/**
 * Builder methods for possible validation rules.
 *
 * @method static Rules\Alnum alnum(int $min = null, int $max = null)
 * @method static Rules\Alpha alpha(int $min = null, int $max = null)
 * @method static Rules\Boolean boolean(int $min = null, int $max = null)
 * @method static Rules\Chain chain(Rule ...$rules)
 * @method static Rules\Contains contains(string $text)
 * @method static Rules\Date date(string $format = null, $min = null, $max = null)
 * @method static Rules\Email email()
 * @method static Rules\Falsy falsy()
 * @method static Rules\Group group(array $definition)
 * @method static Rules\In in(...$possibleValues)
 * @method static Rules\Integer integer(int $min = null, int $max = null)
 * @method static Rules\Ip ip()
 * @method static Rules\Ipv4 ipv4()
 * @method static Rules\Ipv6 ipv6()
 * @method static Rules\Number number(float $min = null, float $max = null)
 * @method static Rules\Uuid uuid()
 * @method static Rules\Regex regex(string $regex)
 * @method static Rules\Text text(int $min = null, int $max = null)
 * @method static Rules\Truthy truthy()
 * @method static Rules\Uri uri()
 * @method static Rules\Url url()
 *
 * @example:
 * Constrain::alnum(2)('test');
 *
 */
abstract class Rule implements Validator
{
    use StaticFactory;

    private const RULES_NAMESPACE = '\\Igni\\Validation\\Rules\\';

    /** @var string */
    protected $name;

    /** @var array */
    protected $attributes = [];

    protected $failures = [];

    abstract protected function assert($input): bool;

    public function __invoke($input): bool
    {
        return $this->validate($input);
    }

    public function validate($input): bool
    {
        $this->attributes['input'] = $input;

        if (empty($input)) {
            if (isset($this->attributes['required']) && $this->attributes['required']) {
                $this->failures[] = ValidationFailure::forEmptyValue($this);
                return false;
            }

            if (isset($this->attributes['required']) && !$this->attributes['required']) {
                return true;
            }
        }

        $assert = $this->assert($input);

        if (!$assert) {
            $this->failures[] = ValidationFailure::forAssertionFailure($this);
            return false;
        }

        if ($this instanceof RangeRule && $this->assertRange($input) !== 0) {
            if (isset($this->attributes['min'], $this->attributes['max'])) {
                $this->failures[] = ValidationFailure::forOutOfRange($this);
            } else {
                if ($this->assertRange($input) > 0) {
                    $this->failures[] = ValidationFailure::forValueTooHigh($this);
                } else {
                    $this->failures[] = ValidationFailure::forValueTooLow($this);
                }
            }

            return false;
        }

        if ($this instanceof LengthRule && $this->assertLength($input) !== 0) {
            if (isset($this->attributes['min'], $this->attributes['max'])) {
                $this->failures[] = ValidationFailure::forInvalidLength($this);
            } else {
                if ($this->assertLength($input) > 0) {
                    $this->failures[] = ValidationFailure::forValueTooLong($this);
                } else {
                    $this->failures[] = ValidationFailure::forValueTooShort($this);
                }
            }

            return false;
        }

        unset($this->attributes['input']);

        return true;
    }

    public function required(bool $required = true): Rule
    {
        $this->attributes['required'] = $required;

        return $this;
    }

    public function setName(string $name): Rule
    {
        $this->attributes['name'] = $name;
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFailures(): array
    {
        return $this->failures;
    }

    public function getAttributes(): array
    {
        $this->attributes['name'] = $this->attributes['name'] ?? 'Input for ' . get_class($this) . '::assert()';
        return $this->attributes;
    }
}
