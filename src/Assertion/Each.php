<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;
use Igni\Validation\ValidationError;
use Igni\Validation\Validator;

class Each extends Assertion
{
    private $assertion;

    public function __construct(Validator $assertion)
    {
        $this->assertion = $assertion;
    }

    public function assert($input): bool
    {
        if (!is_iterable($input)) {
            return false;
        }

        foreach ($input as $item) {
            if (!$this->assertion->validate($item)) {
                $this->errors = array_merge($this->errors, $this->assertion->getErrors());
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
}
