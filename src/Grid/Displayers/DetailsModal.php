<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Support\Helper;
use D4T\Admin\UI\BS5\Widgets\Modals\DetailsModal as WidgetModal;

class DetailsModal extends AbstractDisplayer
{
    protected string $staticBody = "";

    public function staticBody(string $value): void
    {
        $this->staticBody = $value;
    }

    protected function setUpLazyRenderable(LazyRenderable $renderable)
    {
        return clone $renderable->payload(['key' => $this->getKey()]);
    }

    public function display($title = '', $staticBody = null, $callback = null)
    {
        $staticHtml = $this->value;
        $dynamicHtml = '';

        if ($staticBody instanceof \Closure) {
            $staticBody = $staticBody->call($this, $this->row->getAttributes()['details']);
            $staticHtml = Helper::render($staticBody);
        }

        if ($callback && is_string($callback) && is_subclass_of($callback, LazyRenderable::class)) {
            $dynamicHtml = $this->setUpLazyRenderable($callback::make());
        } elseif ($callback && $callback instanceof LazyRenderable) {
            $dynamicHtml = $this->setUpLazyRenderable($callback);
        }

        return WidgetModal::make()
            ->title($title)
            ->staticBody($staticHtml)
            ->body($dynamicHtml)
            ->delay(300)
            ->button($this->renderButton());
    }

    protected function renderButton(): string
    {
        return <<<HTML
        <button type="button" class="cp-details-modal__button">
            $this->value
            <span class="icomoon-link-arrow"></span>
        </button>
        HTML;
    }
}
