<?php declare(strict_types=1);

namespace Igni\Validation\Message;

use Igni\Validation\Message;
use Igni\Validation\ValidationError;

interface MessageFactory
{
    public function create(ValidationError $failure): Message;
}
