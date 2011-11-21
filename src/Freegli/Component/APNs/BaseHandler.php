<?php

namespace Freegli\Component\APNs;

abstract class BaseHandler
{
    const PROTOCOL = 'ssl';

    private $connectionFactory;

    /**
     * @var resource
     */
    private $resource;

    /**
     * @var string
     */
    private $url;

    public function __construct($connectionFactory, $debug = false)
    {
        $this->connectionFactory = $connectionFactory;

        $this->url = sprintf('%s://%s:%s',
            static::PROTOCOL,
            $debug ? static::SANDBOX_HOST : static::PRODUCTION_HOST,
            static::PORT
        );
    }

    public function __destruct()
    {
        $this->closeResource();
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        if (!$this->resource) {
            $this->resource = $this->connectionFactory->getConnection($this->url);
        }

        return $this->resource;
    }

    public function closeResource()
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
        $this->resource = null;
    }
}
