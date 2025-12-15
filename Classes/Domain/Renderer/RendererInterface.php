<?php

namespace Saccas\Mjml\Domain\Renderer;

/**
 * Defines API of possible renderers.
 */
interface RendererInterface
{
    /**
     * Convert mjml strings into html.
     */
    public function getHtmlFromMjml(string $mjml): string;
}
