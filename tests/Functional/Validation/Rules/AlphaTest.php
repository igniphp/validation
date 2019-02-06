<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Exception\ValidationException;
use Igni\Validation\Rules\Alpha;
use PHPUnit\Framework\TestCase;

class AlphaTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Alpha(1, 10);
        self::assertTrue($validator->isValid('a'));
        self::assertTrue($validator->isValid('abc'));
    }

    public function testFailure(): void
    {
        $validator = new Alpha(2, 10);
        self::assertFalse($validator->isValid('a a'));
        self::assertFalse($validator->isValid('12'));
        self::assertFalse($validator->isValid('a1'));
        self::assertFalse($validator->isValid(''));
    }

    public function testFailOnReversedRange(): void
    {
        $this->expectException(ValidationException::class);
        new Alpha(10, 2);
    }
}
