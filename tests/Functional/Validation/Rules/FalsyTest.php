<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\Falsy;
use PHPUnit\Framework\TestCase;

class FalsyTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Falsy();
        self::assertTrue($validator->isValid('no'));
        self::assertTrue($validator->isValid('off'));
        self::assertTrue($validator->isValid(0));
        self::assertTrue($validator->isValid(false));
        self::assertTrue($validator->isValid('false'));

    }

    public function testFailure(): void
    {
        $validator = new Falsy();
        self::assertFalse($validator->isValid('yes'));
        self::assertFalse($validator->isValid('1'));
        self::assertFalse($validator->isValid('nono'));
        self::assertFalse($validator->isValid(true));
    }
}
