<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\ViewiBridge\TypedResponse;
use Components\Models\PostModel;

class Posts extends BaseController
{
    public function index($id): TypedResponse
    {
        $postModel          = new PostModel();
        $postModel->Id      = (int) $id;
        $postModel->Name    = 'CodeIgniter4 ft. Viewi';
        $postModel->Version = 1;
    
        $response = (new TypedResponse())->setJSON($postModel);
        return $response;
    }
}
