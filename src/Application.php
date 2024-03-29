<?php

namespace Dcat\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Container\Container;

class Application
{
    use Macroable;

    const DEFAULT = 'admin';

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $apps;

    /**
     * 所有启用应用的配置.
     *
     * @var array
     */
    protected $configs = [];

    /**
     * 当前应用名称.
     *
     * @var string
     */
    protected $name;

    public function __construct(Container $app)
    {
        $this->container = $app;
    }

    public function getApps()
    {
        return $this->apps ?: ($this->apps = (array) config('admin.multi_app'));
    }

    public function isEnabled(string $app) : bool {
        return in_array($app, $this->getEnabledApps());
    }

    public function getEnabledApps() : array
    {
        return array_filter($this->getApps());
    }

    public function switch(string $app = null)
    {
        $this->withName($app);

        $this->withConfig($this->name);
    }

    public function withName(string $app)
    {
        $this->name = $app;
    }

    public function getName()
    {
        return $this->name ?: static::DEFAULT;
    }

    public function boot()
    {
        $currentApp = static::DEFAULT;
        $this->registerRoute(static::DEFAULT);

        if ($apps = $this->getApps()) {
            $this->registerMultiAppRoutes();

            if(request()) {
                $hostName = request()->getHost();
            }   else
                $hostName = Str::of(config('app.url'))->remove('http://')->remove('https://');

            foreach ($apps as $app => $enable) {
                if ($enable && $hostName == config("{$app}.route.domain") ) {
                    $currentApp = $app;
                }
            }

            //dd($currentApp);
            $this->switch($currentApp);
        }
    }

    public function routes($pathOrCallback)
    {
        $name = $this->getName();
        //dd('w');
        $this->switch(static::DEFAULT);
        $this->loadRoutesFrom($pathOrCallback, static::DEFAULT);

        if ($apps = $this->getApps()) {
            foreach ($apps as $app => $enable) {
                if ($enable) {
                    $this->switch($app);

                    $this->loadRoutesFrom($pathOrCallback, $app);
                }
            }

            $this->switch(static::DEFAULT);
        }

        $this->switch($name);
    }

    protected function registerMultiAppRoutes()
    {
        foreach ($this->getApps() as $app => $enable) {
            if ($enable) {
                $this->registerRoute($app);
            }
        }
    }

    public function getCurrentApiRoutePrefix()
    {
        return $this->getApiRoutePrefix($this->getName());
    }

    public function getApiRoutePrefix(?string $app = null)
    {
        return $this->getRoutePrefix($app).'dcat-api.';
    }

    public function getRoutePrefix(?string $app = null)
    {
        $app = $app ?: $this->getName();

        return 'dcat.'.$app.'.';
    }

    public function getRoute(?string $route, array $params = [], $absolute = true)
    {
        return route($this->getRoutePrefix().$route, $params, $absolute);
    }

    public function registerRoute(?string $app)
    {
        $name = $this->getName();
        $this->switch($app);

        $this->loadRoutesFrom(function () {
            Admin::registerApiRoutes();
        }, $app);

        if (is_file($routes = config("{$app}.directory").'/routes.php')) {
            $this->loadRoutesFrom($routes, $app);
        }

        $this->switch($name);
    }

    protected function withConfig(string $app)
    {
        if (! isset($this->configs[$app])) {
            $this->configs[$app] = config($app);
        }

        //$settings = array_merge($this->configs[$app], admin_setting_array($app));

        //config([$app => $settings]);
        config(['admin' => $this->configs[$app]]);
    }

    protected function loadRoutesFrom($path, ?string $app)
    {
        Route::group(array_filter([
            'middleware' => 'admin.app:'.$app,
            'domain'     => config("{$app}.route.domain"),
            'as'         => $this->getRoutePrefix($app),
        ]), $path);
    }
}
