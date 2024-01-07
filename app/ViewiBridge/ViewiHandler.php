<?php

namespace App\ViewiBridge;

use App\Controllers\BaseController;
use Exception;
use Throwable;
use Viewi\App;
use Viewi\Components\Http\Message\Request;
use Viewi\Router\ComponentRoute;
use Viewi\Router\Router;

class ViewiHandler extends BaseController
{
    protected static App $viewiApp;
    protected static Router $viewiRouter;

    public function handle()
    {
        try {
            $urlPath = str_replace('/index.php', '', $this->request->getUri()->getPath());
            $requestMethod = $this->request->getMethod();
            $match = self::$viewiRouter->resolve($urlPath, $requestMethod);
            if ($match === null) {
                throw new Exception('No route was matched!');
            }
            /** @var RouteItem */
            $routeItem = $match['item'];
            $action = $routeItem->action;

            if ($action instanceof ComponentRoute) {
                $viewiRequest = new Request($urlPath, strtolower($requestMethod));
                $response = self::$viewiApp->engine()->render($action->component, $match['params'], $viewiRequest);

                $this->response->setBody($response->body);
                foreach ($response->headers as $key => $value) {
                    $this->response->setHeader($key, $value);
                }
                $this->response->setStatusCode(isset($response->headers['Location']) ? 302 : $response->status);
            } else {
                throw new Exception('Unknown action type.');
            }
            $this->response->send();
        } catch (Throwable $ex) {
            echo $ex->__toString();
        }
    }

    public static function setViewiApp(App $viewiApp)
    {
        self::$viewiApp = $viewiApp;
        self::$viewiRouter = $viewiApp->router();
    }
}
