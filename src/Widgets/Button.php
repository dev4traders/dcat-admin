<?php

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Widgets\Widget;
use Dcat\Admin\Enums\ButtonClassType;

class Button extends Widget
{
    public function __construct(protected string $title, protected ?string $href = null, protected ButtonClassType $type = ButtonClassType::PRIMARY)
    {
    }

    public function render()
    {
        $this->class($this->type->_());

        $atr = $this->formatHtmlAttributes();

//        dd($atr);

        return <<<HTML
        <a href="{$this->href}"><button type="button" $atr>$this->title</button></a>
HTML;
    }
}
