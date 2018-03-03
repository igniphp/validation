<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class In extends Rule
{
    public function __construct(...$values)
    {
        $this->attributes['valid_values'] = $values;
    }

    protected function assert($input): bool
    {
        return in_array($input, $this->attributes['valid_values'], $strict = true);
    }
}
