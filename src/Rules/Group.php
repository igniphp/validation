<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Exception\ValidationException;
use Igni\Validation\Rule;
use Igni\Validation\ValidationFailure;
use ArrayAccess;

class Group extends Rule
{
    /** @var Rule[] */
    private $group;

    public function __construct(array $group)
    {
        $this->validateRules($group);

        $this->group = $group;
    }

    public function assert($input): bool
    {
        $this->failures = [];
        if (!is_array($input) && !$input instanceof ArrayAccess) {
            return false;
        }
        foreach ($this->group as $name => $rule) {
            if (!$rule($input[$name] ?? null)) {
                $this->failures[] =  $rule->getFailures()[0];
            }
        }

        if ($this->failures) {
            return false;
        }

        return true;
    }

    /**
     * @return ValidationFailure[]
     */
    public function getFailures(): array
    {
        // Remove the last assertion failure, as we dont need it
        $failures = parent::getFailures();
        array_pop($failures);

        return $failures;
    }

    private function validateRules(array $rules): void
    {
        foreach($rules as $name => $rule) {
            if (!$rule instanceof Rule) {
                throw ValidationException::forInvalidRule($rule);
            }
            $rule->setName($name);
        }
    }
}
