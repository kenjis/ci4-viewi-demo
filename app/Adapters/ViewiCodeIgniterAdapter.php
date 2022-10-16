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

        // Viewi routes: /, *, {userId}, {userId}, {name?}, {query<[A-Za-z]+>?}
        // replace route params `{name}` with placeholders.
        // {name} {name?} -> (:segment)
        // * -> (:any)
        $ciUrl = '';
        $parts = explode('/', str_replace('*', '(:any)', trim($url, '/')));
        $paramNames = [];
        foreach ($parts as $segment) {
            if ($segment !== '' && $segment[0] === '{') {
                $strLen = strlen($segment) - 1;
                $regOffset = -2;
                $regex = null;
                if ($segment[$strLen - 1] === '?') // {optional?}
                {
                    $strLen -= 1;
                    $regOffset = -3;
                }
                if ($segment[$strLen - 1] === '>') // {<regex>}
                {
                    $strLen -= 1;
                    $regParts = explode('<', $segment);
                    $segment = $regParts[0];
                    // {<regex>} -> ([a-z]+), (\d+)
                    $regex = substr($regParts[1], 0, $regOffset);
                    $regex = '(' . $regex . ')';
                }
                $paramName = substr($segment, 1, $strLen - 1);
                $paramNames[] = $paramName;
                $segment = $regex ?? '(:segment)';
            }
            $ciUrl .= '/' . $segment;
        }

        $routes->{$method}($ciUrl, static function (...$params) use ($component, $paramNames) {
            $controller = new ViewiCodeIgniterComponent($component);
            // collect params
            $viewiParams = [];
            foreach ($paramNames as $i => $name) {
                if ($i < count($params)) {
                    $viewiParams[$name] = $params[$i];
                }
            }
            return $controller->index($viewiParams);
        }, ['as' => $component]); 
        // Question: Has 'as' parameter to be unique ? 
        // if so, we need to add some random or incremented value to it
        // since the component can be attached to multiple routes
        // UseCase /posts/new, /posts/5 -> CreateEditPost component
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
        $request->setPath($url);
        $app->setRequest($request);

        $response = $app->run(null, true);

        if ($response instanceof RawJsonResponse) {
            return $response->getRawData();
        }

        return json_decode($response->getBody());
    }
}
