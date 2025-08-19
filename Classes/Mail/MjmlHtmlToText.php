<?php

declare(strict_types=1);

namespace Saccas\Mjml\Mail;

use Html2Text\Html2Text;

class MjmlHtmlToText implements MjmlHtmlToTextInterface
{
    public function convert(string $html): string
    {
        return (new Html2Text($html))->getText();
    }
}
