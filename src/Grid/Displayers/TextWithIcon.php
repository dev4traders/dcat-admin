<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Admin;

class TextWithIcon extends AbstractDisplayer
{
    public function display(string $icon = '', bool $prepend = true, string $class = '')
    {
        return Admin::view('admin::grid.displayer.text-with-icon', [
            'icon' => $icon,
            'prepend' => $prepend,
            'class' => $class,
            'label' => $this->value
        ]);
    }
}
