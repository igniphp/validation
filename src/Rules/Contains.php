<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Contains extends Rule
{
    public function __construct(string $contains)
    {
        $this->attributes['contains'] = $contains;
        $this->attributes['ignore_case'] = false;
    }

    public function ignoreCase(bool $ignore = true): Contains
    {
        $this->attributes['ignore_case'] = $ignore;

        return $this;
    }

    protected function assert($input): bool
    {
        if ($this->attributes['ignore_case']) {
            return false !== stripos((string) $input, $this->attributes['contains']);
        }

        return false !== strpos((string) $input, $this->attributes['contains']);
    }
}
