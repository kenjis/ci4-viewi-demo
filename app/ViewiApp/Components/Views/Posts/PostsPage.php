<?php

namespace Components\Views\Posts;

use Components\Models\PostModel;
use Viewi\BaseComponent;
use Viewi\Common\HttpClient;

class PostsPage extends BaseComponent
{
    public string $title = 'Viewi - Reactive application for PHP';

    public ?PostModel $post = null;

    public function __init(HttpClient $http, int $postId)
    {
        $http->get("/api/posts/$postId")->then(function (PostModel $data) {
            $this->post = $data;
        }, function ($error) {
            echo $error;
        });
    }
}
