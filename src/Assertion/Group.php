<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Exception\InvalidArgumentException;
use Igni\Validation\Assertion;
use Igni\Validation\ValidationError;
use ArrayAccess;

class Group extends Assertion
{
    /** @var Assertion[] */
    private $group;

    public function __construct(array $group)
    {
        $this->validateRules($group);

        $this->group = $group;
    }

    public function assert($input): bool
    {
        $this->errors = [];
        if (!is_array($input) && !$input instanceof ArrayAccess) {
            return false;
        }
        foreach ($this->group as $name => $rule) {
            if (!$rule->isValid($input[$name] ?? null)) {
                $this->errors[] = $rule->getErrors()[0];
            }
        }

        if ($this->errors) {
            return false;
        }

        return true;
    }

    /**
     * @return ValidationError[]
     */
    public function getErrors(): array
    {
        // Remove the last assertion failure, as we dont need it
        $failures = parent::getErrors();
        array_pop($failures);

        return $failures;
    }

    private function validateRules(array $rules): void
    {
        foreach($rules as $name => $rule) {
            if (!$rule instanceof Assertion) {
                throw InvalidArgumentException::forInvalidRule($rule);
            }
            $rule->setName($name);
        }
    }
}
