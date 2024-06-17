<?php

namespace App\Domain\ReactEmail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\HtmlString;

class ReactMailable extends Mailable
{
    protected function buildView(): array
    {
        return array_map(
            fn ($content) => new HtmlString($content),
            Renderer::render($this->view, $this->buildViewData())
        );
    }
}
