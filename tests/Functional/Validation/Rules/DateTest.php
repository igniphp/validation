<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Utils\TestCase;
use Igni\Validation\Rules\Date;

class DateTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Date();
        self::assertTrue($validator('2017-02-01'));
        self::assertTrue($validator('01-02-2017'));
        self::assertTrue($validator('1.2.2017'));

        $validator = new Date('Y-m-d');
        self::assertTrue($validator('2017-12-13'));

        $validator = new Date('m.d.Y');
        self::assertTrue($validator('12.13.2017'));
    }

    public function testFailure(): void
    {
        $validator = new Date();
        self::assertFalse($validator('2017-20-20'));
        self::assertFalse($validator('20171'));
        self::assertFalse($validator('20.20.2017'));

        $validator = new Date('Y-m-d');
        self::assertFalse($validator('2017.12.13'));

        $validator = new Date('m.d.Y');
        self::assertFalse($validator('12-13-2017'));
    }
}
