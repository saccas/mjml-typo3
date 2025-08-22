<?php

declare(strict_types=1);

namespace Saccas\Mjml\Mail;

interface MjmlHtmlToTextInterface
{
    public function convert(string $html): string;
}
