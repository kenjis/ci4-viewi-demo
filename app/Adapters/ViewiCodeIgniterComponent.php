<?php

namespace App\Adapters;

use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Viewi\App;

class ViewiCodeIgniterComponent
{
    private string $component;

    public function __construct(string $component)
    {
        $this->component = $component;
    }

    public function index(array $params): ResponseInterface
    {
        $response = Services::response();

        $viewiResponse = App::run($this->component, $params);

        if (isset(($this->component)::$STATUS_CODE)) {
            $response->setStatusCode(($this->component)::$STATUS_CODE);
        }

        if (is_string($viewiResponse)) { // html
            return $response->setBody($viewiResponse);
        }

        return $response;
    }
}
