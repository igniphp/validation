<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Exception\InvalidArgumentException;
use Igni\Utils\TestCase;
use Igni\Validation\Exception\ValidationException;
use Igni\Validation\Rules\Alpha;

class AlphaTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Alpha(1, 10);
        self::assertTrue($validator('a'));
        self::assertTrue($validator('abc'));
    }

    public function testFailure(): void
    {
        $validator = new Alpha(2, 10);
        self::assertFalse($validator('a a'));
        self::assertFalse($validator('12'));
        self::assertFalse($validator('a1'));
        self::assertFalse($validator(''));
    }

    public function testFailOnReversedRange(): void
    {
        $this->expectException(ValidationException::class);
        new Alpha(10, 2);
    }
}
