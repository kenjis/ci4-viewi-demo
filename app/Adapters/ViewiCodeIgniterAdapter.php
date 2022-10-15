<?php

namespace App\Adapters;

use CodeIgniter\CodeIgniter;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Router\RouteCollection;
use Config\Services;
use Viewi\Routing\RouteAdapterBase;

class ViewiCodeIgniterAdapter extends RouteAdapterBase
{
    private CodeIgniter $app;

    public function __construct(CodeIgniter $app)
    {
        $this->app = $app;
    }

    public function register($method, $url, $component, $defaults): void
    {
        /** @var RouteCollection $routes */
        $routes = Services::routes();

        // replace route params `{name}` with placeholders.
        // @TODO now supports only `{name}`.
        $url = preg_replace('/{\w+?}/', '(:segment)', $url);

        $routes->{$method}($url, static function (...$params) use ($component) {
            $controller = new ViewiCodeIgniterComponent($component);

            return $controller->index($params);
        }, ['as' => $component]);
    }

    public function handle($method, $url, $params = null)
    {
        /** @var CodeIgniter $app */
        $app = Services::codeigniter(null, false);
        $app->initialize();
        $context = is_cli() ? 'php-cli' : 'web';
        $app->setContext($context);
        $app->disableFilters();

        $uri       = new URI();
        $userAgent = new UserAgent();
        $request   = new IncomingRequest(
            config('App'),
            $uri,
            'php://input',
            $userAgent
        );
        $request->setMethod($method);
        $request->setPath($url);
        $app->setRequest($request);

        $response = $app->run(null, true);

        if ($response instanceof RawJsonResponse) {
            return $response->getRawData();
        }

        return json_decode($response->getBody());
    }
}
