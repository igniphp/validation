<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Utils\Uuid as UuidGenerator;

use Igni\Validation\Rule;

class Uuid extends Rule
{
    protected function assert($input): bool
    {
        try {
            return UuidGenerator::validate($input) || UuidGenerator::validate(UuidGenerator::fromShort($input));
        } catch (\Throwable $ex) {
            return false;
        }
    }
}
