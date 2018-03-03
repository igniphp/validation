<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Integer extends Rule implements RangeRule
{
    use RangeRuleTrait;

    public function __construct(int $min = null, int $max = null)
    {
        if ($min !== null) {
            $this->attributes['min'] = $min;
        }

        if ($max !== null) {
            $this->attributes['max'] = $max;
        }
    }

    protected function assert($input): bool
    {
        return is_int($input);
    }
}
