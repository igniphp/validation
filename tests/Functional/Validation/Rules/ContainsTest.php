<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Contains;
use PHPUnit\Framework\TestCase;

class ContainsTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Contains('needle');
        self::assertTrue($validator->isValid('this string has needle'));
        self::assertTrue($validator->isValid('needle is in this string'));
        self::assertTrue($validator->isValid('string with needle in the middle'));
    }

    public function testFailure(): void
    {
        $validator = new Contains('needle');
        self::assertFalse($validator->isValid('1'));
        self::assertFalse($validator->isValid('true'));
        self::assertFalse($validator->isValid('false'));
        self::assertFalse($validator->isValid(1));
    }
}
