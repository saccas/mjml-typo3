<?php

namespace Saccas\Mjml\View;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Utility\CommandUtility;

class MjmlBasedView extends StandaloneView
{
    function render()
    {
        return $this->getHtmlFromMjml(parent::render());
    }

    protected function getHtmlFromMjml($mjml)
    {
        $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mjml']);

        $temporaryMjmlFileWithPath = GeneralUtility::tempnam('mjml_', '.mjml');
        $mjmlFile = fopen($temporaryMjmlFileWithPath, 'w');
        fwrite($mjmlFile, $mjml);
        fclose($mjmlFile);

        // see https://mjml.io/download and https://www.npmjs.com/package/mjml-cli
        $cmd = $configuration['nodeBinaryPath'] . ' ' . $configuration['mjmlBinaryPath'] . $configuration['mjmlBinary'] .' ' . $configuration['mjmlParams'] . ' ' . $temporaryMjmlFileWithPath;

        $result = [];
        $returnValue = '';
        CommandUtility::exec($cmd, $result, $returnValue);

        return implode('',$result);
    }
}
