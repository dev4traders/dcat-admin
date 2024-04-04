<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Admin;

class CountryFlag extends AbstractDisplayer
{
    public function display()
    {
        return Admin::view(
            'admin::grid.displayer.country-flag',
            [
                'value' => $this->value,
                'label' => $this->value
            ]
        );
    }
}
