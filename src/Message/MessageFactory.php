<?php declare(strict_types=1);

namespace Igni\Validation\Message;

use Igni\Validation\Message;
use Igni\Validation\ValidationFailure;

interface MessageFactory
{
    public function create(ValidationFailure $failure): Message;
}
