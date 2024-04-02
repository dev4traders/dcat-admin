<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Admin;

class CountryFlag extends AbstractDisplayer
{
    public function display(string $img = '', string $class = '')
    {
        return Admin::view(
            'admin::grid.displayer.country-flag',
            [
                'value' => $this->value,
                'class' => $class
            ]
        );
    }
}
