<?php

namespace Dcat\Admin\Grid\Displayers;

use D4T\Core\Enums\StyleClassType;
use Dcat\Admin\Admin;

class Rating extends AbstractDisplayer
{
    public function display($max_value = 0, StyleClassType $color = StyleClassType::PRIMARY)
    {
        if( $this->value > $max_value ) {
            return $this->value;
        }

        return Admin::view(
            'admin::grid.displayer.rating',
            [
                'value' => $this->value,
                'class' => $color()
            ]
        );
    }
}
