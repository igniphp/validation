<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\In;
use PHPUnit\Framework\TestCase;

class InTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new In('test', 1, '2', false);
        self::assertTrue($validator('test'));
        self::assertTrue($validator(1));
        self::assertTrue($validator('2'));
        self::assertTrue($validator(false));
    }

    public function testFailure(): void
    {
        $validator = new In('test', 1, '2', false);
        self::assertFalse($validator('yes'));
        self::assertFalse($validator('1'));
        self::assertFalse($validator(2));
        self::assertFalse($validator(true));
    }
}
