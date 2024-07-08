<?php

namespace App\Domain\ReactEmail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\HtmlString;

abstract class ReactMailable extends Mailable
{
    public abstract function envelope(): Envelope;

    protected function buildView(): array
    {
        return array_map(
            fn ($content) => new HtmlString($content),
            Renderer::render($this->view, $this->buildViewData())
        );
    }
}
