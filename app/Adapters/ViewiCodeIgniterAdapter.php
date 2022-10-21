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
    private array $nameTracker = [];
    private RouteSyntaxConverter $converter;

    public function __construct(CodeIgniter $app, RouteSyntaxConverter $converter)
    {
        $this->app       = $app;
        $this->converter = $converter;
    }

    /**
     * @param string     $method
     * @param string     $url
     * @param string     $component
     * @param array|null $defaults
     */
    public function register($method, $url, $component, $defaults): void
    {
        /** @var RouteCollection $routes */
        $routes = Services::routes();

        [$ciUrl, $paramNames] = $this->converter->convert($url);

        if (! isset($this->nameTracker[$component])) {
            $this->nameTracker[$component] = -1;
        }

        $this->nameTracker[$component]++;
        $as = ($this->nameTracker[$component] === 0) ? $component
            : "{$component}-{$this->nameTracker[$component]}";

        $routes->{$method}($ciUrl, static function (...$params) use ($component, $paramNames, $defaults) {
            $controller = new ViewiCodeIgniterComponent($component, $defaults);
            // collect params
            $viewiParams = [];

            foreach ($paramNames as $i => $name) {
                if ($i < count($params)) {
                    $viewiParams[$name] = $params[$i];
                }
            }

            return $controller->index($viewiParams);
        }, ['as' => $as]);
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
