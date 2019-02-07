<?php declare(strict_types=1);

namespace Igni\Validation;

interface Validator
{
    /**
     * @param mixed $input
     * @return bool
     */
    public function validate($input): bool;

    /**
     * @return ValidationError[]
     */
    public function getErrors(): array;
}
