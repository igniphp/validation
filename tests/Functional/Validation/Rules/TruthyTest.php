<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Truthy;
use PHPUnit\Framework\TestCase;

class TruthyTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Truthy();
        self::assertTrue($validator('on'));
        self::assertTrue($validator('yes'));
        self::assertTrue($validator(1));
        self::assertTrue($validator(true));
        self::assertTrue($validator('true'));

    }

    public function testFailure(): void
    {
        $validator = new Truthy();
        self::assertFalse($validator('no'));
        self::assertFalse($validator('0'));
        self::assertFalse($validator('false'));
        self::assertFalse($validator('off'));
        self::assertFalse($validator('random string'));
    }
}
