<?php

namespace Components\Views\Posts;

use Components\Models\PostModel;
use Viewi\Components\BaseComponent;
use Viewi\Components\Http\HttpClient;

class PostsPage extends BaseComponent
{
    public string $title = 'Viewi - Reactive application for PHP';

    public ?PostModel $post = null;

    public function __construct(private HttpClient $http, private int $postId)
    {
    }

    public function init()
    {
        $this->http->get("/api/posts/{$this->postId}")->then(function (PostModel $data) {
            $this->post = $data;
        }, function ($error) {
            echo $error;
        });
    }
}
