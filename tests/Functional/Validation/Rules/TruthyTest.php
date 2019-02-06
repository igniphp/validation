<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Truthy;
use PHPUnit\Framework\TestCase;

class TruthyTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Truthy();
        self::assertTrue($validator->isValid('on'));
        self::assertTrue($validator->isValid('yes'));
        self::assertTrue($validator->isValid(1));
        self::assertTrue($validator->isValid(true));
        self::assertTrue($validator->isValid('true'));

    }

    public function testFailure(): void
    {
        $validator = new Truthy();
        self::assertFalse($validator->isValid('no'));
        self::assertFalse($validator->isValid('0'));
        self::assertFalse($validator->isValid('false'));
        self::assertFalse($validator->isValid('off'));
        self::assertFalse($validator->isValid('random string'));
    }
}
