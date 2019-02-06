<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\Boolean;
use PHPUnit\Framework\TestCase;

class BooleanTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Boolean();
        self::assertTrue($validator->isValid(true));
        self::assertTrue($validator->isValid(false));
    }

    public function testFailure(): void
    {
        $validator = new Boolean();
        self::assertFalse($validator->isValid('1'));
        self::assertFalse($validator->isValid('true'));
        self::assertFalse($validator->isValid('false'));
        self::assertFalse($validator->isValid(1));
    }
}
