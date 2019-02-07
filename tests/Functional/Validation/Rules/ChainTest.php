<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Assertion\Chain;
use Igni\Validation\Assertion\Email;
use Igni\Validation\Assertion\Text;
use PHPUnit\Framework\TestCase;

class ChainTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Chain(new Text(), new Email());
        self::assertTrue($validator->validate('test@dom.com'));
        self::assertTrue($validator->validate('test@domain.com'));
    }

    public function testFailure(): void
    {
        $validator = new Chain(new Text(), new Email());
        self::assertFalse($validator->validate('1'));
        self::assertFalse($validator->validate('true'));
        self::assertFalse($validator->validate('false'));
        self::assertFalse($validator->validate(1));
    }
}
