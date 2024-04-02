<?php

namespace Dcat\Admin\Grid\Displayers;

class PriceDisplay extends AbstractDisplayer
{
    public function display(string $currency = '$', bool $colored = true)
    {
        if(is_null($this->value))
            return '';

        if(is_string($this->value)) {
            $this->value = (float)$this->value;
        }

        $class = "text-success";
        $value = $currency.$this->value;
        if($this->value < 0) {
            $class = "text-danger";
            $value = "-".$currency.abs($this->value);
        }

        if(!$colored) {
            $class = "";
        }

        return "<span class='".$class."'>".$value."</span>";
    }
}
