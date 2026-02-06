<?php

declare(strict_types=1);

namespace Saccas\Mjml\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

abstract class AbstractFunctionalTestCase extends FunctionalTestCase
{
    protected function setUp(): void
    {
        $this->coreExtensionsToLoad = [
            'typo3/cms-form',
        ];

        $this->testExtensionsToLoad = [
            'saccas/mjml',
        ];

        $this->configurationToUseInTestInstance = [
            'EXTENSIONS' => [
                'mjml' => [
                    'nodeBinaryPath' => getenv('NODE_BIN_PATH') ?: 'node',
                    'mjmlBinaryPath' => 'node_modules/mjml/bin/',
                    'mjmlBinary' => 'mjml',
                    'mjmlParams' => '-s --config.beautify true --noStdoutFileComment',
                ],
            ],
        ];

        parent::setUp();
    }

    protected function cleanUpGeneratedOutput(string $output): string
    {
        return preg_replace(
            '/<!-- FILE: (.*)-->/Uis',
            '',
            $output
        ) ?? '';
    }
}
