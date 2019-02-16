<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion;
use PHPUnit\Framework\TestCase;
use ArrayIterator;

class EachTest extends TestCase
{
    /**
     * @dataProvider provideValidData
     */
    public function testPass(iterable $set): void
    {
        $validator = Assertion::each(Assertion::date('Y-m-d'));
        self::assertTrue($validator->validate($set));
    }

    /**
     * @dataProvider provideInvalidData
     */
    public function testFailure($set): void
    {
        $validator = Assertion::each(Assertion::date('Y-m-d'));
        self::assertFalse($validator->validate($set));
    }

    public function provideValidData(): array
    {
        return [
            [
                ['2019-09-02', '2022-10-10', '1999-11-11'],
            ],
            [
                new ArrayIterator(['2019-09-02', '2022-10-10', '1999-11-11']),
            ]
        ];
    }


    public function provideInvalidData(): array
    {
        return [
            [
                ['2019', '2022-10-10', '1999-11-11'],
            ],
            [
                new ArrayIterator(['2019-09-02', '2022', '1999-11-11']),
            ],
            [
                1
            ]
        ];
    }
}
