<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Exception\ValidationException;
use Igni\Validation\Rules\Alnum;
use PHPUnit\Framework\TestCase;

class AlnumTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Alnum(1, 10);
        self::assertTrue($validator('a1'));
        self::assertTrue($validator('12345'));
        self::assertTrue($validator('test'));
        self::assertTrue($validator('Test'));
    }

    public function testFailure(): void
    {
        $validator = new Alnum(2, 10);
        self::assertFalse($validator('a'));
        self::assertFalse($validator('12345678910'));
        self::assertFalse($validator('&*@^'));
        self::assertFalse($validator(''));
    }

    public function testFailOnReversedRange(): void
    {
        $this->expectException(ValidationException::class);
        new Alnum(10, 2);
    }
}
