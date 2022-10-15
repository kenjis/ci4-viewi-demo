<?php

namespace App\Adapters;

use CodeIgniter\CodeIgniter;
use Config\Services;
use Exception;
use Viewi\Routing\Route;
use Viewi\Routing\Router;

/**
 * Viewi initializer
 */
class Viewi
{
    /**
     * Initialize Viewi
     */
    public static function init(CodeIgniter $app): void
    {
        $adapter = new ViewiCodeIgniterAdapter($app);
        Route::setAdapter($adapter);

        /** @var RouteCollection $routes */
        $routes = Services::routes();
        $routes->set404Override(static function () {
            $request = Services::request();
            $url = $request->getUri()->getPath();
            $method = $request->getMethod(); // deprecated, is there any other way to get the method?
            $viewiResponse = Router::handle($url, $method);
            if (is_string($viewiResponse)) { // html
                echo $viewiResponse; // TODO: how to return the Response object, not echoing the output. Use case: Viewi gets the HTML page of some component (with HttpClient), needed as a string, not echo.
            }
            throw new Exception("String content expected!");
        });

        require __DIR__ . '/../ViewiApp/viewi.php';
    }
}
