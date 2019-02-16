<?php declare(strict_types=1);

namespace Igni\Validation;

use Igni\Validation\Assertion\LengthRule;
use Igni\Validation\Assertion\RangeRule;

/**
 * Class Assertion
 * @package Igni\Validation
 */
abstract class Assertion implements Validator
{
    use StaticRuleFactory;

    /** @var string */
    protected $name;

    /** @var array */
    protected $attributes = [];

    /** @var ValidationError[] */
    protected $errors = [];

    abstract protected function assert($input): bool;

    public function validate($input): bool
    {
        $this->attributes['input'] = $input;

        if (empty($input)) {
            if (isset($this->attributes['required']) && $this->attributes['required']) {
                $this->errors[] = ValidationError::forEmptyValue($this);
                return false;
            }

            if (isset($this->attributes['required']) && !$this->attributes['required']) {
                return true;
            }
        }

        $assert = $this->assert($input);

        if (!$assert) {
            $this->errors[] = ValidationError::forAssertionFailure($this);
            return false;
        }

        if ($this instanceof RangeRule && $this->assertRange($input) !== 0) {
            if (isset($this->attributes['min'], $this->attributes['max'])) {
                $this->errors[] = ValidationError::forOutOfRange($this);
            } else {
                if ($this->assertRange($input) > 0) {
                    $this->errors[] = ValidationError::forValueTooHigh($this);
                } else {
                    $this->errors[] = ValidationError::forValueTooLow($this);
                }
            }

            return false;
        }

        if ($this instanceof LengthRule && $this->assertLength($input) !== 0) {
            if (isset($this->attributes['min'], $this->attributes['max'])) {
                $this->errors[] = ValidationError::forInvalidLength($this);
            } else {
                if ($this->assertLength($input) > 0) {
                    $this->errors[] = ValidationError::forValueTooLong($this);
                } else {
                    $this->errors[] = ValidationError::forValueTooShort($this);
                }
            }

            return false;
        }

        unset($this->attributes['input']);

        return true;
    }

    public function required(bool $required = true): Assertion
    {
        $this->attributes['required'] = $required;

        return $this;
    }

    public function setName(string $name): Assertion
    {
        $this->attributes['name'] = $name;
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getAttributes(): array
    {
        $this->attributes['name'] = $this->attributes['name'] ?? 'Input for ' . get_class($this) . '::assert()';
        return $this->attributes;
    }
}
