<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Alnum extends Rule implements LengthRule
{
    use LengthRuleTrait;

    public function __construct(int $min = null, int $max = null, bool $diacritics = false)
    {
        $this->setExpectedLength($min, $max);
        $this->attributes['diacritics'] = $diacritics;
    }

    public function diacritics($allow = true): Alnum
    {
        $this->attributes['diacritics'] = $allow;
        return $this;
    }

    protected function assert($input): bool
    {
        if ($this->attributes['diacritics']) {
            return mb_ereg_match('^[[:alnum:]]*$', $input);
        }
        return ctype_alnum($input);
    }
}
