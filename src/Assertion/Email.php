<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Email extends Assertion
{
    private const MATCHER = '/^([^\s^@]{2,})+([a-z]{1})?[^\.]@[^\.^-][^@]+\.[a-z0-9]{2,}$/i';

    protected function assert($input): bool
    {
        $result = is_string($input) && preg_match(self::MATCHER, $input);

        // There should be never two dots in group
        if ($result && strpos($input, '..')) {
            return false;
        }

        return $result;
    }
}
