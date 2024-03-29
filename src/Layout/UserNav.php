<?php

namespace Dcat\Admin\Layout;

use Dcat\Admin\DcatIcon;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Enums\RouteAuth;
use Illuminate\Support\Collection;
use Dcat\Admin\Layout\UserNavElement;
use Dcat\Admin\Traits\HasBuilderEvents;

class UserNav
{
    use HasBuilderEvents;

    protected Collection $elements;

    public function __construct()
    {
        $this->elements = collect();
    }

    public function put(UserNavElement $element) : UserNav
    {
        $this->elements->push($element);

        return $this;
    }

    public function renderElements() : string {
        $this->callComposing('render-user-nav');

        $this->put(new UserNavElement($this, admin_route(RouteAuth::SECURITY()), DcatIcon::LOCK(), __('admin.security')));
        $this->put(new UserNavElement($this, admin_route(RouteAuth::AUTH_LOG()), DcatIcon::MAP(), __('admin.auth_log')));
        $this->put(new UserNavElement($this, admin_route(RouteAuth::PROFILE()), DcatIcon::PROFILE(), __('admin.profile')));

        $this->put(new UserNavElement($this, admin_route(RouteAuth::LOGOUT()), DcatIcon::LOGOUT(), __('admin.logout'), null, true));

        return $this->elements->map([Helper::class, 'render'])->implode('');
    }
}
