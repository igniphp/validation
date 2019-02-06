<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Regex extends Assertion
{
    public function __construct(string $pattern)
    {
        $this->attributes['pattern'] = $pattern;
    }

    protected function assert($input): bool
    {
        return (bool) preg_match($this->attributes['pattern'], $input);
    }
}
