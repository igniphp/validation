<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Alpha extends Assertion implements LengthRule
{
    use LengthRuleTrait;

    public function __construct(int $min = null, int $max = null)
    {
        $this->setExpectedLength($min, $max);
    }

    protected function assert($input): bool
    {
        return ctype_alpha($input);
    }
}
