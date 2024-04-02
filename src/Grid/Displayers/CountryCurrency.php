<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Admin;

class CountryCurrency extends AbstractDisplayer
{
    private function countryCodeToCurrencyCode(string $code): string
    {
        switch($code) {
            case 'ru': {
                return 'rub';
            }
            case 'us': {
                return 'usd';
            }
        }

        return $code;
    }

    public function display()
    {
        return Admin::view(
            'admin::grid.displayer.country-flag',
            [
                'value' => $this->value,
                'label' => $this->countryCodeToCurrencyCode($this->value),
                'class' => 'gray-bg'
            ]
        );
    }
}
