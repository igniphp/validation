<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\Boolean;
use PHPUnit\Framework\TestCase;

class BooleanTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Boolean();
        self::assertTrue($validator->validate(true));
        self::assertTrue($validator->validate(false));
    }

    public function testFailure(): void
    {
        $validator = new Boolean();
        self::assertFalse($validator->validate('1'));
        self::assertFalse($validator->validate('true'));
        self::assertFalse($validator->validate('false'));
        self::assertFalse($validator->validate(1));
    }
}
