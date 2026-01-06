<?php

declare(strict_types=1);

namespace Saccas\Mjml\Mail;

use Saccas\Mjml\Domain\Renderer\RendererInterface;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\TemplatePaths;

class MjmlFluidEmail extends FluidEmail
{
    public const MJML_FORMAT_HTML = 'html';
    public const MJML_FORMAT_TXT = 'txt';

    public const MJML_FORMATS = [
        self::MJML_FORMAT_HTML,
        self::MJML_FORMAT_TXT,
    ];

    protected RendererInterface $renderer;
    protected MjmlHtmlToTextInterface $html2text;

    protected ?string $cacheHtmlRenderResult = null;

    public function __construct(
        ?TemplatePaths $templatePaths = null,
        ?Headers $headers = null,
        ?AbstractPart $body = null,
        ?RendererInterface $renderer = null,
        ?MjmlHtmlToTextInterface $html2text = null,
    ) {
        parent::__construct($templatePaths, $headers, $body);

        $this->renderer = $renderer instanceof RendererInterface
            ? $renderer
            : GeneralUtility::makeInstance(RendererInterface::class);

        $this->html2text = $html2text instanceof MjmlHtmlToTextInterface
            ? $html2text
            : GeneralUtility::makeInstance(MjmlHtmlToTextInterface::class);
    }

    protected function renderContent(string $format): string
    {
        if (!in_array($format, self::MJML_FORMATS, true)) {
            throw new \RuntimeException(sprintf('Invalid format "%s", please provide one of %s', $format, implode(',', self::MJML_FORMATS)));
        }

        if ($this->cacheHtmlRenderResult === null) {
            $this->view->getRenderingContext()->getTemplatePaths()->setFormat(self::MJML_FORMAT_HTML);
            $this->cacheHtmlRenderResult = $this->renderer->getHtmlFromMjml($this->view->render($this->templateName));
        }

        if ($format === self::MJML_FORMAT_TXT) {
            $this->view->getRenderingContext()->getTemplatePaths()->setFormat($format);
            return $this->html2text->convert($this->cacheHtmlRenderResult);
        }

        $this->view->getRenderingContext()->getTemplatePaths()->setFormat($format);
        return $this->cacheHtmlRenderResult;
    }
}
