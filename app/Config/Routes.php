<?php

use App\Controllers\Api\Posts;
use App\ViewiBridge\ViewiHandler;
use App\ViewiBridge\ViewiCodeIgniterBridge;
use CodeIgniter\Router\RouteCollection;
use Viewi\App;
use Viewi\Bridge\IViewiBridge;

/**
 * @var RouteCollection $routes
 */

$routes->get('api/posts/(:num)', [Posts::class, 'index']);


/**
 * Viewi set up
 * The idea is to let Viewi handle its own routes by registering a 404 action
 * @param RouteCollection $routes 
 * @return void 
 */
function viewiSetUp(RouteCollection $routes)
{
    /**
     * @var App
     */
    $app = require __DIR__ . '/../ViewiApp/viewi.php';
    require __DIR__ . '/../ViewiApp/routes.php';
    $bridge = new ViewiCodeIgniterBridge();
    $app->factory()->add(IViewiBridge::class, function () use ($bridge) {
        return $bridge;
    });
    ViewiHandler::setViewiApp($app);

    $routes->set404Override('App\ViewiBridge\ViewiHandler::handle');
}

viewiSetUp($routes);
