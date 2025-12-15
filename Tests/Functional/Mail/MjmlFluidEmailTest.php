<?php

namespace Saccas\Mjml\Tests\Functional\Mail;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use Saccas\Mjml\Domain\Renderer\Command;
use Saccas\Mjml\Mail\MjmlFluidEmail;
use Saccas\Mjml\Mail\MjmlHtmlToText;
use Saccas\Mjml\Tests\Functional\AbstractFunctionalTestCase;
use TYPO3\CMS\Fluid\View\TemplatePaths;

#[CoversClass(MjmlFluidEmail::class)]
#[CoversClass(MjmlHtmlToText::class)]
#[UsesClass(Command::class)]
final class MjmlFluidEmailTest extends AbstractFunctionalTestCase
{
    #[Test]
    public function viewCallsRendererAndReturnsRenderedHtml(): void
    {
        $templatePaths = new TemplatePaths();
        $templatePaths->setTemplateRootPaths([
            'EXT:mjml/Tests/Functional/Mail/MjmlFluidEmailTestFixture/Templates/',
        ]);

        $subject = new MjmlFluidEmail($templatePaths);

        $html = $subject->getHtmlBody();
        self::assertIsString($html);
        self::assertStringEqualsFile(
            __DIR__ . '/MjmlFluidEmailTestFixture/Expected.html',
            $this->cleanUpGeneratedOutput($html),
            'Command renderer did not return expected HTML.'
        );

        $text = $subject->getTextBody();
        self::assertIsString($text);
        self::assertStringEqualsFile(
            __DIR__ . '/MjmlFluidEmailTestFixture/Expected.txt',
            $text,
            'Rendering of view did not return expected plain text.'
        );
    }
}
