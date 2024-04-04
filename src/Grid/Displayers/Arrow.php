<?php

namespace Dcat\Admin\Grid\Displayers;

use D4T\Core\Enums\StyleClassType;

class Arrow extends AbstractDisplayer
{
    public function display(StyleClassType $colorUp = StyleClassType::SUCCESS, StyleClassType $colorDown = StyleClassType::DANGER): string
    {
        $class = $colorUp;
        $orientation = "up";
        if( $this->value < 0 ) {
            $class = $colorDown;
            $orientation = "down";
        }

        return '<span class="cp-table-cell cp-table-cell_arrowed cp-table-cell_arrowed-'.$orientation.' cp-table-cell_arrowed-'.$class->value.'">'.
            '<span class="cp-table-cell__text">'.
                $this->value.
            '</span>'.
        '</span>';
    }
}
