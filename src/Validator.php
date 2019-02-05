<?php declare(strict_types=1);

namespace Igni\Validation;

interface Validator
{
    /**
     * @param mixed $input
     */
    public function validate($input): void;

    /**
     * @param mixed $input
     * @return bool
     */
    public function isValid($input): bool;

    /**
     * @return ValidationError[]
     */
    public function getErrors(): array;
}
