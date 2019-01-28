<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Number('12', '10000000000000000000000');
        self::assertTrue($validator(13));
        self::assertTrue($validator('13'));
        self::assertTrue($validator('13.55'));
        self::assertTrue($validator(13.55));
        self::assertTrue($validator('1000000000000000000000'));
        self::assertFalse($validator('11'));
        self::assertFalse($validator('100000000000000000000001'));
    }

    public function testFailure(): void
    {
        $validator = new Number();
        self::assertFalse($validator('aaa'));
        self::assertFalse($validator('a1a11a'));
        self::assertFalse($validator('a1a11a'));
    }
}
