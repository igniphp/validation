<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\Contains;
use PHPUnit\Framework\TestCase;

class ContainsTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Contains('needle');
        self::assertTrue($validator->validate('this string has needle'));
        self::assertTrue($validator->validate('needle is in this string'));
        self::assertTrue($validator->validate('string with needle in the middle'));
    }

    public function testFailure(): void
    {
        $validator = new Contains('needle');
        self::assertFalse($validator->validate('1'));
        self::assertFalse($validator->validate('true'));
        self::assertFalse($validator->validate('false'));
        self::assertFalse($validator->validate(1));
    }
}
