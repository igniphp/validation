<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\In;
use PHPUnit\Framework\TestCase;

class InTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new In('test', 1, '2', false);
        self::assertTrue($validator->isValid('test'));
        self::assertTrue($validator->isValid(1));
        self::assertTrue($validator->isValid('2'));
        self::assertTrue($validator->isValid(false));
    }

    public function testFailure(): void
    {
        $validator = new In('test', 1, '2', false);
        self::assertFalse($validator->isValid('yes'));
        self::assertFalse($validator->isValid('1'));
        self::assertFalse($validator->isValid(2));
        self::assertFalse($validator->isValid(true));
    }
}
