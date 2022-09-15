<?php

declare(strict_types=1);

namespace Saccas\Mjml\View;

use Saccas\Mjml\Domain\Renderer\RendererInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class MjmlBasedView extends StandaloneView
{
    protected RendererInterface $renderer;

    public function __construct(
        ContentObjectRenderer $contentObject,
        RendererInterface $renderer
    ) {
        parent::__construct($contentObject);

        $this->renderer = $renderer;
    }

    public function render($actionName = null): string
    {
        return $this->renderer->getHtmlFromMjml(parent::render($actionName));
    }
}
