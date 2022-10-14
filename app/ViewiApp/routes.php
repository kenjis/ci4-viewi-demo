<?php

use Components\Views\Home\HomePage;
use Components\Views\Pages\CounterPage;
use Components\Views\Pages\TodoAppPage;
use Viewi\Routing\Route as ViewiRoute;

ViewiRoute::get('/', HomePage::class);
ViewiRoute::get('/counter', CounterPage::class);
ViewiRoute::get('/todo', TodoAppPage::class);
