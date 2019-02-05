<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Chain extends Rule
{
    /** @var Rule[] */
    private $chain;

    public function __construct(Rule ...$rules)
    {
        $this->chain = $rules;
    }

    protected function assert($input): bool
    {
        foreach ($this->chain as $rule) {
            if (!$rule($input)) {
                $this->errors[] = $rule->getErrors();
            }
        }

        if ($this->errors) {
            return false;
        }

        return true;
    }
}
