<?php

namespace App\ViewiBridge;

use CodeIgniter\CodeIgniter;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use Viewi\Bridge\DefaultBridge;
use Viewi\Components\Http\Message\Request;

class ViewiCodeIgniterBridge extends DefaultBridge
{
    public function __construct()
    {
    }

    public function request(Request $viewiRequest): mixed
    {
        if ($viewiRequest->isExternal) {
            return parent::request($viewiRequest);
        }

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
        $request->setMethod($viewiRequest->method);
        $request->setPath($viewiRequest->url);
        $app->setRequest($request);

        $response = $app->run(null, true);

        if ($response instanceof TypedResponse) {
            return $response->getRawData();
        }

        return json_decode($response->getBody());
    }
}
