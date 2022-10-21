<?php

namespace App\Controllers\Api;

use App\Adapters\RawJsonResponse;
use App\Controllers\BaseController;
use Components\Models\PostModel;

class Posts extends BaseController
{
    public function index($id): RawJsonResponse
    {
        $postModel          = new PostModel();
        $postModel->Id      = (int) $id;
        $postModel->Name    = 'CodeIgniter4 ft. Viewi';
        $postModel->Version = 1;

        $response = new RawJsonResponse();

        return $response->setData($postModel)->withJsonHeader();
    }
}
