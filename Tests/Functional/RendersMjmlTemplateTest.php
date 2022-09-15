<?php

declare(strict_types=1);

namespace Saccas\Mjml\Tests\Functional;

use Saccas\Mjml\View\MjmlBasedView;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class RendersMjmlTemplateTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/mjml',
    ];

    protected $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'mjml' => [
                'nodeBinaryPath' => 'node',
                'mjmlBinaryPath' => './node_modules/mjml/bin/',
                'mjmlBinary' => 'mjml',
                'mjmlParams' => '-s --noStdoutFileComment',
            ],
        ],
    ];

    /**
     * @test
     */
    public function returnsHtmlResult(): void
    {
        $subject = $this->get(MjmlBasedView::class);
        $subject->setTemplateSource(file_get_contents(__DIR__ . '/Fixtures/Input.mjml'));

        $result = $subject->render();

        self::assertStringEqualsFile(__DIR__ . '/Fixtures/Expected.html', $result);
    }
}
