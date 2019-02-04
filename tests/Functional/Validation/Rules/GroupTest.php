<?php declare(strict_types=1);

namespace IgniTestFunctional\Validator\Rules;

use Igni\Validation\Rule;
use Igni\Validation\Failures\EmptyValueFailure;
use Igni\Validation\Failures\OutOfRangeFailure;
use Igni\Validation\Rules\Group;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    public function testAllSucceed(): void
    {
        $validateUserData = new Group([
            'name' => Rule::text()->required(false),
            'email' => Rule::email(),
            'age' => Rule::integer(2, 100),
        ]);

        $result = $validateUserData([
            'email' => 'test@email.com',
            'age' => 21,
        ]);

        self::assertTrue($result);
    }

    public function testWhenFails(): void
    {
        $validateUserData = new Group([
            'name' => Rule::text(),
            'email' => Rule::email(),
            'age' => Rule::integer(2, 100),
        ]);

        $result = $validateUserData([
            'name' => 'John Test',
            'age' => 121,
        ]);

        self::assertFalse($result);

        $failures = $validateUserData->getFailures();

        self::assertCount(2, $failures);
        self::assertInstanceOf(EmptyValueFailure::class, $failures[0]);
        self::assertInstanceOf(OutOfRangeFailure::class, $failures[1]);
    }

    public function testAllowEmpty(): void
    {
        $validateUserData = new Group([
            'name' => Rule::text(),
            'email' => Rule::email(),
            'age' => Rule::integer(2, 100),
        ]);
        $validateUserData->allowEmpty('email');

        self::assertTrue($validateUserData([
            'name' => 'John Test',
            'age' => 99,
        ]));

        self::assertFalse($validateUserData([
            'email' => 'test@email.com',
            'age' => 99,
        ]));
    }
}
