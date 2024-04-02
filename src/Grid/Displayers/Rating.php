<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Admin;

class Rating extends AbstractDisplayer
{

    public function display($max_value = 0)
    {
        if( $this->value > $max_value ) {
            return $this->value;
        }

        return Admin::view(
            'admin::grid.displayer.rating',
            ['value' => $this->value]
        );
    }
}
