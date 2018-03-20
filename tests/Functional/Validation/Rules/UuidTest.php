<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function testPass(): void
    {
        if (!class_exists(Igni\Utils\Uuid::class)) {
            self::markTestSkipped('Common library is not available.');
            return;
        }
        $validator = new Uuid();
        self::assertTrue($validator(Igni\Utils\Uuid::generate()));
        self::assertTrue($validator(Igni\Utils\Uuid::generateShort()));
    }

    public function testFailure(): void
    {
        if (!class_exists(Igni\Utils\Uuid::class)) {
            self::markTestSkipped('Common library is not available.');
            return;
        }
        $validator = new Uuid();
        self::assertFalse($validator('no'));
        self::assertFalse($validator('0'));
        self::assertFalse($validator('false'));
        self::assertFalse($validator('off'));
        self::assertFalse($validator('random string'));
    }
}
