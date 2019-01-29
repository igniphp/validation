<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Integer;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Integer(10, 20);
        self::assertTrue($validator(10));
        self::assertTrue($validator(11));
        self::assertTrue($validator(12));
        self::assertTrue($validator(20));
    }

    public function testFailure(): void
    {
        $validator = new Integer(10, 20);
        self::assertFalse($validator('11'));
        self::assertFalse($validator(9));
        self::assertFalse($validator(21));
        self::assertFalse($validator(true));
    }
}
