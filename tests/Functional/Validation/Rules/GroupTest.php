<?php declare(strict_types=1);

namespace IgniTestFunctional\Validator\Rules;

use Igni\Validation\Rule;
use Igni\Validation\Error\EmptyValueError;
use Igni\Validation\Error\OutOfRangeError;
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

        $result = $validateUserData->isValid([
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

        $result = $validateUserData->isValid([
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
            'name' => Rule::text(),
            'email' => Rule::email()->required(false),
            'age' => Rule::integer(2, 100),
        ]);

        self::assertTrue($validateUserData->isValid([
            'name' => 'John Test',
            'age' => 99,
        ]));

        self::assertFalse($validateUserData->isValid([
            'email' => 'test@email.com',
            'age' => 99,
        ]));
    }
}
