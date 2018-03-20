<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Boolean;
use PHPUnit\Framework\TestCase;

class BooleanTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Boolean();
        self::assertTrue($validator(true));
        self::assertTrue($validator(false));
    }

    public function testFailure(): void
    {
        $validator = new Boolean();
        self::assertFalse($validator('1'));
        self::assertFalse($validator('true'));
        self::assertFalse($validator('false'));
        self::assertFalse($validator(1));
    }
}
