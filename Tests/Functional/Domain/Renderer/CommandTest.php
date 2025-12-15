<?php

namespace Saccas\Mjml\Tests\Functional\Domain\Renderer;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Saccas\Mjml\Domain\Renderer\Command;
use Saccas\Mjml\Tests\Functional\AbstractFunctionalTestCase;

#[CoversClass(Command::class)]
final class CommandTest extends AbstractFunctionalTestCase
{
    #[Test]
    public function htmlIsReturnedForMjml(): void
    {
        $subject = $this->get(Command::class);

        $result = $subject->getHtmlFromMjml(
            file_get_contents(__DIR__ . '/CommandTestFixture/Basic.mjml') ?: ''
        );

        self::assertStringEqualsFile(
            __DIR__ . '/CommandTestFixture/Expected.html',
            $this->cleanUpGeneratedOutput($result),
            'Command renderer did not return expected HTML.'
        );
    }
}
