<?php

namespace Dcat\Admin\Grid\Displayers;

use D4T\Core\Enums\StyleClassType;
use Dcat\Admin\Admin;

class ColoredText extends AbstractDisplayer
{
    public function display(StyleClassType $color = StyleClassType::PRIMARY)
    {
        return Admin::view('admin::grid.displayer.colored-text', [
            'label' => $this->value,
            'color' => $color()
        ]);
    }
}
