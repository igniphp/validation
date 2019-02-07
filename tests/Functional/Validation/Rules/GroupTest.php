<?php declare(strict_types=1);

namespace IgniTestFunctional\Validator\Rules;

use Igni\Validation\Assertion;
use Igni\Validation\Error\EmptyValueError;
use Igni\Validation\Error\OutOfRangeError;
use Igni\Validation\Assertion\Group;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    public function testAllSucceed(): void
    {
        $validateUserData = new Group([
            'name' => Assertion::text()->required(false),
            'email' => Assertion::email(),
            'age' => Assertion::integer(2, 100),
        ]);

        $result = $validateUserData->validate([
            'email' => 'test@email.com',
            'age' => 21,
        ]);

        self::assertTrue($result);
    }

    public function testWhenFails(): void
    {
        $validateUserData = new Group([
            'name' => Assertion::text(),
            'email' => Assertion::email(),
            'age' => Assertion::integer(2, 100),
        ]);

        $result = $validateUserData->validate([
            'name' => 'John Test',
            'age' => 121,
        ]);

        self::assertFalse($result);

        $failures = $validateUserData->getErrors();

        self::assertCount(2, $failures);
        self::assertInstanceOf(EmptyValueError::class, $failures[0]);
        self::assertInstanceOf(OutOfRangeError::class, $failures[1]);
    }

    public function testAllowEmpty(): void
    {
        $validateUserData = new Group([
            'name' => Assertion::text(),
            'email' => Assertion::email()->required(false),
            'age' => Assertion::integer(2, 100),
        ]);

        self::assertTrue($validateUserData->validate([
            'name' => 'John Test',
            'age' => 99,
        ]));

        self::assertFalse($validateUserData->validate([
            'email' => 'test@email.com',
            'age' => 99,
        ]));
    }
}
