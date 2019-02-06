<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Chain extends Assertion
{
    /** @var Assertion[] */
    private $chain;

    public function __construct(Assertion ...$rules)
    {
        $this->chain = $rules;
    }

    protected function assert($input): bool
    {
        foreach ($this->chain as $rule) {
            if (!$rule->isValid($input)) {
                $this->errors[] = $rule->getErrors();
            }
        }

        if ($this->errors) {
            return false;
        }

        return true;
    }
}
