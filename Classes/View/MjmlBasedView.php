<?php
namespace Saccas\Mjml\View;

use Saccas\Mjml\Domain\Renderer\RendererInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class MjmlBasedView extends StandaloneView
{
    protected ?RendererInterface $renderer = null;

    public function __construct(ContentObjectRenderer $contentObject = null, RendererInterface $renderer = null)
    {
        parent::__construct($contentObject);

        $this->renderer = $renderer;
        if ($this->renderer === null) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $this->renderer = $objectManager->get(RendererInterface::class);
        }
    }

    public function render($actionName = null): string
    {
        return $this->renderer->getHtmlFromMjml(parent::render($actionName));
    }
}
