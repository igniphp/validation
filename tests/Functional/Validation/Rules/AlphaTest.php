<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Exception\InvalidArgumentException;
use Igni\Validation\Assertion\Alpha;
use PHPUnit\Framework\TestCase;

class AlphaTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Alpha(1, 10);
        self::assertTrue($validator->validate('a'));
        self::assertTrue($validator->validate('abc'));
    }

    public function testFailure(): void
    {
        $validator = new Alpha(2, 10);
        self::assertFalse($validator->validate('a a'));
        self::assertFalse($validator->validate('12'));
        self::assertFalse($validator->validate('a1'));
        self::assertFalse($validator->validate(''));
    }

    public function testFailOnReversedRange(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Alpha(10, 2);
    }
}
