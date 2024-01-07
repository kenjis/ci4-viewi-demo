<?php

use Components\Views\Home\HomePage;
use Components\Views\NotFound\NotFoundPage;
use Components\Views\Pages\CounterPage;
use Components\Views\Pages\TodoAppPage;
use Components\Views\Posts\PostsPage;
use Viewi\App;
use Viewi\Components\Http\Message\Response;

/**
 * @var App $app
 */
$router = $app->router();

$router->get('/', HomePage::class);
$router->get('/counter', CounterPage::class);
$router->get('/todo', TodoAppPage::class);
$router->get('/posts/{postId}', PostsPage::class);

// 404 page, at the end.
$router
    ->get('*', NotFoundPage::class)
    ->transform(function (Response $response) {
        return $response->withStatus(404, 'Not Found');
    });
