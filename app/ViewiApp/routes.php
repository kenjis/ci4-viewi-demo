<?php

use Components\Views\Home\HomePage;
use Components\Views\NotFound\NotFoundPage;
use Components\Views\Pages\CounterPage;
use Components\Views\Pages\TodoAppPage;
use Components\Views\Posts\PostsPage;
use Viewi\Routing\Route as ViewiRoute;

ViewiRoute::get('/', HomePage::class);
ViewiRoute::get('/counter', CounterPage::class);
ViewiRoute::get('/todo', TodoAppPage::class);
ViewiRoute::get('/posts/new', PostsPage::class);
ViewiRoute::get('/posts/{postId?}', PostsPage::class);
ViewiRoute::get('/postsa/{postIdA}', PostsPage1::class);
ViewiRoute::get('/postsb/{postIdB<[0-9]+>}', PostsPage2::class);
ViewiRoute::get('/postsc/{postIdC<[0-9]+>?}', PostsPage3::class);

// 404 page, at the end.
ViewiRoute::get('*', NotFoundPage::class, [
    'statusCode' => 404,
]);
