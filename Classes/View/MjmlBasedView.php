<?php

namespace Saccas\Mjml\View;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Cli\Command;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Utility\CommandUtility;

class MjmlBasedView extends StandaloneView
{
    public function render($actionName = null)
    {
        return $this->getHtmlFromMjml(parent::render($actionName));
    }

    protected function getHtmlFromMjml($mjml)
    {
        $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mjml']);

        $temporaryMjmlFileWithPath = GeneralUtility::tempnam('mjml_', '.mjml');

        GeneralUtility::writeFileToTypo3tempDir($temporaryMjmlFileWithPath, $mjml);

        // see https://mjml.io/download and https://www.npmjs.com/package/mjml-cli
        $cmd = $configuration['nodeBinaryPath'] . ' ' . $configuration['mjmlBinaryPath'] . $configuration['mjmlBinary'];
        $args = $configuration['mjmlParams'] . ' ' . $temporaryMjmlFileWithPath;

        $result = [];
        $returnValue = '';
        CommandUtility::exec($this->getEscapedCommand($cmd, $args), $result, $returnValue);

        GeneralUtility::unlink_tempfile($temporaryMjmlFileWithPath);

        return implode('',$result);
    }

    /**
     * @param string $cmd
     * @param string $args
     * @return string
     */
    private function getEscapedCommand(string $cmd, string $args) {
        $escapedCmd = escapeshellcmd($cmd);

        $argsArray = explode(' ', $args);
        $escapedArgsArray = CommandUtility::escapeShellArguments($argsArray);
        $escapedArgs = implode(' ', $escapedArgsArray);

        return $escapedCmd . ' ' . $escapedArgs;
    }
}
