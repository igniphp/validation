<?php declare(strict_types=1);

namespace Igni\Validation;

interface Validator
{
    /**
     * @param array $data
     * @return bool
     */
    public function validate($data): bool;

    /**
     * @return ValidationFailure[]
     */
    public function getFailures(): array;
}
