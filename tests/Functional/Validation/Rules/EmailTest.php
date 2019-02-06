<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * @param string $address
     * @dataProvider provideValidEmails
     */
    public function testPass(string $address): void
    {
        $validator = new Email();
        self::assertTrue($validator->isValid($address));
    }

    /**
     * @param string $address
     * @dataProvider provideInvalidEmails
     */
    public function testFailure(string $address): void
    {
        $validator = new Email();
        self::assertFalse($validator->isValid($address));
    }

    public function provideValidEmails(): array
    {
        return [
            ['email@example.com'],
            ['firstname.lastname@example.com'],
            ['email@subdomain.example.com'],
            ['firstname+lastname@example.com'],
            ['email@123.123.123.123'],
            ['"email"@example.com'],
            ['1234567890@example.com'],
            ['email@example-one.com'],
            ['_______@example.com'],
            ['email@example.name'],
            ['email@example.museum'],
            ['email@example.co.jp'],
            ['firstname-lastname@example.com'],
        ];
    }

    public function provideInvalidEmails(): array
    {
        return [
            ['plainaddress'],
            ['#@%^%#$@#$@#.com'],
            ['\'@example.com'],
            ['Joe Smith <email@example.com>'],
            ['    email.example.com'],
            ['email@example@example.com'],
            ['    .email@example.com'],
            ['email.@example.com'],
            ['email..email@example.com'],
            ['email@example.com (Joe Smith)'],
            ['email@example'],
            ['email@-example.com'],
            ['email@example..com'],
            ['Abc..123@example.com'],
        ];
    }
}
