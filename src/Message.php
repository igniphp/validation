<?php declare(strict_types=1);

namespace Igni\Validation;

class Message
{
    protected const INTERPOLATION_PATTERN = '${%s}';
    protected $message;
    protected $context;

    public function __construct(string $message, Assertion $context)
    {
        $this->message = $message;
        $this->context = $context;
    }

    public function getContext(): Assertion
    {
        return $this->context;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    private function getTranslations(): array
    {
        $params = [];
        foreach($this->context->getAttributes() as $name => $value)
        {
            $params[sprintf(self::INTERPOLATION_PATTERN, $name)] = $value;
        }
        return $params;
    }

    public function __toString(): string
    {
        return strtr($this->message, $this->getTranslations());
    }
}
