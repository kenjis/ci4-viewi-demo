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
        require __DIR__ . '/../ViewiApp/viewi.php';
    }
}
