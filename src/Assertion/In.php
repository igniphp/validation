<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class In extends Assertion
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
