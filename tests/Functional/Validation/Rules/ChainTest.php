<?php declare(strict_types=1);

namespace IgniTest\Functional\Validation\Rules;

use Igni\Validation\Rules\Chain;
use Igni\Validation\Rules\Email;
use Igni\Validation\Rules\Text;
use PHPUnit\Framework\TestCase;

class ChainTest extends TestCase
{
    public function testPass(): void
    {
        $validator = new Chain(new Text(), new Email());
        self::assertTrue($validator->isValid('test@dom.com'));
        self::assertTrue($validator->isValid('test@domain.com'));
    }

    public function testFailure(): void
    {
        $validator = new Chain(new Text(), new Email());
        self::assertFalse($validator->isValid('1'));
        self::assertFalse($validator->isValid('true'));
        self::assertFalse($validator->isValid('false'));
        self::assertFalse($validator->isValid(1));
    }
}
