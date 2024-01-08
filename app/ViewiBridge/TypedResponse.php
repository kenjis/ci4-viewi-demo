<?php

namespace App\ViewiBridge;

use CodeIgniter\HTTP\Response;

class TypedResponse extends Response
{
    /**
     * @var array|object
     */
    private $rawData;

    public function __construct()
    {
        $config = config('App');

        parent::__construct($config);
    }

    public function setJSON($body, bool $unencoded = false)
    {
        $this->rawData = $body;
        return parent::setJSON($body, $unencoded);
    }

    /**
     * @return array|object
     */
    public function getRawData()
    {
        return $this->rawData;
    }
}
