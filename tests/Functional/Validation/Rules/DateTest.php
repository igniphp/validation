<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use PHPUnit\Framework\TestCase;
use Igni\Validation\Assertion\Date;

class DateTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Date();
        self::assertTrue($validator->validate('2017-02-01'));
        self::assertTrue($validator->validate('01-02-2017'));
        self::assertTrue($validator->validate('1.2.2017'));

        $validator = new Date('Y-m-d');
        self::assertTrue($validator->validate('2017-12-13'));

        $validator = new Date('m.d.Y');
        self::assertTrue($validator->validate('12.13.2017'));
    }

    public function testFailure(): void
    {
        $validator = new Date();
        self::assertFalse($validator->validate('2017-20-20'));
        self::assertFalse($validator->validate('20171'));
        self::assertFalse($validator->validate('20.20.2017'));

        $validator = new Date('Y-m-d');
        self::assertFalse($validator->validate('2017.12.13'));

        $validator = new Date('m.d.Y');
        self::assertFalse($validator->validate('12-13-2017'));
    }
}
