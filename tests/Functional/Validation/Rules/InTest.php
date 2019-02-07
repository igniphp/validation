<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\In;
use PHPUnit\Framework\TestCase;

class InTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new In('test', 1, '2', false);
        self::assertTrue($validator->validate('test'));
        self::assertTrue($validator->validate(1));
        self::assertTrue($validator->validate('2'));
        self::assertTrue($validator->validate(false));
    }

    public function testFailure(): void
    {
        $validator = new In('test', 1, '2', false);
        self::assertFalse($validator->validate('yes'));
        self::assertFalse($validator->validate('1'));
        self::assertFalse($validator->validate(2));
        self::assertFalse($validator->validate(true));
    }
}
