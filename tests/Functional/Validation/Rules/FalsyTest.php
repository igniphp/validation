<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\Falsy;
use PHPUnit\Framework\TestCase;

class FalsyTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Falsy();
        self::assertTrue($validator->validate('no'));
        self::assertTrue($validator->validate('off'));
        self::assertTrue($validator->validate(0));
        self::assertTrue($validator->validate(false));
        self::assertTrue($validator->validate('false'));

    }

    public function testFailure(): void
    {
        $validator = new Falsy();
        self::assertFalse($validator->validate('yes'));
        self::assertFalse($validator->validate('1'));
        self::assertFalse($validator->validate('nono'));
        self::assertFalse($validator->validate(true));
    }
}
