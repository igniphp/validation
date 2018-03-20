<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Contains;
use PHPUnit\Framework\TestCase;

class ContainsTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Contains('needle');
        self::assertTrue($validator('this string has needle'));
        self::assertTrue($validator('needle is in this string'));
        self::assertTrue($validator('string with needle in the middle'));
    }

    public function testFailure(): void
    {
        $validator = new Contains('needle');
        self::assertFalse($validator('1'));
        self::assertFalse($validator('true'));
        self::assertFalse($validator('false'));
        self::assertFalse($validator(1));
    }
}
