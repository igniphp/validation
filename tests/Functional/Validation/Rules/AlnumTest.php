<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Exception\InvalidArgumentException;
use Igni\Validation\Assertion\Alnum;
use PHPUnit\Framework\TestCase;

class AlnumTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Alnum(1, 10);
        self::assertTrue($validator->validate('a1'));
        self::assertTrue($validator->validate('12345'));
        self::assertTrue($validator->validate('test'));
        self::assertTrue($validator->validate('Test'));
    }

    public function testFailure(): void
    {
        $validator = new Alnum(2, 10);
        self::assertFalse($validator->validate('a'));
        self::assertFalse($validator->validate('12345678910'));
        self::assertFalse($validator->validate('&*@^'));
        self::assertFalse($validator->validate(''));
    }

    public function testFailOnReversedRange(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Alnum(10, 2);
    }
}
