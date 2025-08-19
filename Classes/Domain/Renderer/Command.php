<?php
namespace Saccas\Mjml\Domain\Renderer;

use TYPO3\CMS\Core\Utility\CommandUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class Command implements RendererInterface
{
    /**
     * @var array{nodeBinaryPath: string, mjmlBinaryPath: string, mjmlBinary: string, mjmlParams: string}
     */
    protected array $config = [
        'nodeBinaryPath' => '/usr/bin/node',
        'mjmlBinaryPath' => './node_modules/mjml/bin/',
        'mjmlBinary' => 'mjml',
        'mjmlParams' => '-s --config.beautify true --config.minify true',
    ];

    /**
     * @param $config array{nodeBinaryPath: string, mjmlBinaryPath: string, mjmlBinary: string, mjmlParams: string}
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config); // @phpstan-ignore-line
    }

    public function getHtmlFromMjml(string $mjml): string
    {
        $temporaryMjmlFileWithPath = GeneralUtility::tempnam('mjml_', '.mjml');

        GeneralUtility::writeFileToTypo3tempDir($temporaryMjmlFileWithPath, $mjml);

        $mjmlExtPath = ExtensionManagementUtility::extPath('mjml');

        // see https://mjml.io/download and https://www.npmjs.com/package/mjml-cli
        $cmd = $this->config['nodeBinaryPath'] . ' ' . $mjmlExtPath . $this->config['mjmlBinaryPath'] . $this->config['mjmlBinary'];
        $args = $temporaryMjmlFileWithPath . ' ' . $this->config['mjmlParams'];

        $result = [];
        $returnValue = 0;

        CommandUtility::exec($this->getEscapedCommand($cmd, $args), $result, $returnValue);

        GeneralUtility::unlink_tempfile($temporaryMjmlFileWithPath);

        return implode('', $result);
    }

    /**
     * @param string $cmd
     * @param string $args
     * @return string
     */
    protected function getEscapedCommand(string $cmd, string $args): string
    {
        $escapedCmd = escapeshellcmd($cmd);

        $argsArray = explode(' ', $args);
        $escapedArgsArray = CommandUtility::escapeShellArguments($argsArray);
        $escapedArgs = implode(' ', $escapedArgsArray);

        return $escapedCmd . ' ' . $escapedArgs;
    }
}
