<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\Truthy;
use PHPUnit\Framework\TestCase;

class TruthyTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Truthy();
        self::assertTrue($validator->validate('on'));
        self::assertTrue($validator->validate('yes'));
        self::assertTrue($validator->validate(1));
        self::assertTrue($validator->validate(true));
        self::assertTrue($validator->validate('true'));

    }

    public function testFailure(): void
    {
        $validator = new Truthy();
        self::assertFalse($validator->validate('no'));
        self::assertFalse($validator->validate('0'));
        self::assertFalse($validator->validate('false'));
        self::assertFalse($validator->validate('off'));
        self::assertFalse($validator->validate('random string'));
    }
}
