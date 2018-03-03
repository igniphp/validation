<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Text extends Rule implements LengthRule
{
    use LengthRuleTrait;

    public function __construct(int $min = null, int $max = null)
    {
        $this->setExpectedLength($min, $max);
    }

    protected function assert($input): bool
    {
        return is_string($input);
    }
}
