<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Integer;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Integer(10, 20);
        self::assertTrue($validator->isValid(10));
        self::assertTrue($validator->isValid(11));
        self::assertTrue($validator->isValid(12));
        self::assertTrue($validator->isValid(20));
    }

    public function testFailure(): void
    {
        $validator = new Integer(10, 20);
        self::assertFalse($validator->isValid('11'));
        self::assertFalse($validator->isValid(9));
        self::assertFalse($validator->isValid(21));
        self::assertFalse($validator->isValid(true));
    }
}
