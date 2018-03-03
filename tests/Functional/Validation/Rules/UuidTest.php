<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Utils\TestCase;
use Igni\Utils\Uuid as UuidGenerator;
use Igni\Validation\Rules\Uuid;

class UuidTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Uuid();
        self::assertTrue($validator(UuidGenerator::generate()));
        self::assertTrue($validator(UuidGenerator::generateShort()));

    }

    public function testFailure(): void
    {
        $validator = new Uuid();
        self::assertFalse($validator('no'));
        self::assertFalse($validator('0'));
        self::assertFalse($validator('false'));
        self::assertFalse($validator('off'));
        self::assertFalse($validator('random string'));
    }
}
