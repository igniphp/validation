<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\Integer;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Integer(10, 20);
        self::assertTrue($validator->validate(10));
        self::assertTrue($validator->validate(11));
        self::assertTrue($validator->validate(12));
        self::assertTrue($validator->validate(20));
    }

    public function testFailure(): void
    {
        $validator = new Integer(10, 20);
        self::assertFalse($validator->validate('11'));
        self::assertFalse($validator->validate(9));
        self::assertFalse($validator->validate(21));
        self::assertFalse($validator->validate(true));
    }
}
