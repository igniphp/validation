<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Utils\TestCase;
use Igni\Validation\Rules\Falsy;

class FalsyTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Falsy();
        self::assertTrue($validator('no'));
        self::assertTrue($validator('off'));
        self::assertTrue($validator(0));
        self::assertTrue($validator(false));
        self::assertTrue($validator('false'));

    }

    public function testFailure(): void
    {
        $validator = new Falsy();
        self::assertFalse($validator('yes'));
        self::assertFalse($validator('1'));
        self::assertFalse($validator('nono'));
        self::assertFalse($validator(true));
    }
}
