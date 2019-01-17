<?php

namespace Zapheus\Http\Message;

class MessageFactory
{
    protected $headers = array();

    protected $stream = null;

    protected $version = '1.1';

    public function __construct(MessageInterface $message = null)
    {
        if ($message === null)
        {
            return;
        }

        $this->headers = $message->headers();

        $this->stream = $message->stream();

        $this->version = $message->version();
    }

    public function header($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function headers(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function make()
    {
        return new Message($this->headers, $this->stream, $this->version);
    }

    public function server(array $server)
    {
        foreach ((array) $server as $key => $value)
        {
            $string = strtolower(substr($key, 5));

            $key = str_replace('_', '-', $string);

            if (strpos($key, 'HTTP_') === 0)
            {
                $this->headers[$key] = $value;
            }
        }
    }

    public function stream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }

    public function version($version)
    {
        $this->version = $version;

        return $this;
    }

    public function write($output)
    {
        $resource = fopen('php://temp', 'r+');

        ! $resource && $resource = null;

        $stream = new Stream($resource);

        $stream->write((string) $output);

        $this->stream = $stream;

        return $this;
    }
}
