<?php declare(strict_types=1);

namespace Igni\Validation;

use Igni\Validation\Rules\LengthRule;
use Igni\Validation\Rules\RangeRule;

abstract class Rule implements Validator
{
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
