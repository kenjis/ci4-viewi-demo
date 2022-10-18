<?php

namespace App\Adapters;

use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Viewi\App;

class ViewiCodeIgniterComponent
{
    private string $component;
    private ?array $defaults = null;

    public function __construct(string $component, ?array $defaults = null)
    {
        $this->component = $component;
        $this->defaults  = $defaults;
    }

    public function index(array $params): ResponseInterface
    {
        $response = Services::response();

        $viewiResponse = App::run($this->component, $params);

        if (isset($this->defaults['statusCode'])) {
            $response->setStatusCode($this->defaults['statusCode']);
        }

        if (is_string($viewiResponse)) { // html
            return $response->setBody($viewiResponse);
        }

        return $response;
    }
}
