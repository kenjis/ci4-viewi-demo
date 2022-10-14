<?php

namespace App\Adapters;

use CodeIgniter\HTTP\Response;

/**
 * Response class for Viewi
 */
final class RawJsonResponse extends Response
{
    /**
     * @var array|object
     */
    private $rawData;

    /**
     * @param array|object $data
     *
     * @return $this
     */
    public function setData($data = []): self
    {
        $this->rawData = $data;
        $this->setBody(json_encode($data));

        return $this;
    }

    /**
     * @return array|object
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @return $this
     */
    public function withJsonHeader(): self
    {
        return $this->setHeader('Content-Type', 'application/json');
    }
}
